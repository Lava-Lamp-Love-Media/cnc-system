<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('plan')->latest()->paginate(10);
        return view('backend.superadmin.companies.index', compact('companies'));
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('backend.superadmin.companies.create', compact('plans'));
    }

    // ✅ AJAX: Search user by email
    public function searchUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            // Check if user already assigned to a company
            if ($user->company_id) {
                return response()->json([
                    'found' => true,
                    'assigned' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'company' => $user->company->name
                ]);
            }

            return response()->json([
                'found' => true,
                'assigned' => false,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function store(Request $request)
    {
        // Base validation
        $rules = [
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',
            'company_phone' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:500',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,trial,suspended',
            'assignment_type' => 'required|in:existing,new',
        ];

        // Conditional validation based on assignment type
        if ($request->assignment_type === 'existing') {
            $rules['existing_user_id'] = 'required|exists:users,id';
        } else {
            $rules['admin_name'] = 'required|string|max:255';
            $rules['admin_email'] = 'required|email|unique:users,email';
        }

        $validated = $request->validate($rules, [
            'company_name.required' => 'Company name is required',
            'company_email.required' => 'Company email is required',
            'company_email.unique' => 'This company email already exists',
            'plan_id.required' => 'Please select a plan',
            'plan_id.exists' => 'Selected plan is invalid',
            'admin_name.required' => 'Admin name is required',
            'admin_email.required' => 'Admin email is required',
            'admin_email.unique' => 'This email is already registered',
            'existing_user_id.required' => 'Please select a user',
        ]);

        try {
            // Create Company
            $company = Company::create([
                'name' => $validated['company_name'],
                'email' => $validated['company_email'],
                'phone' => $validated['company_phone'] ?? null,
                'address' => $validated['company_address'] ?? null,
                'plan_id' => $validated['plan_id'],
                'status' => $validated['status'],
                'subscription_start' => now(),
                'subscription_end' => now()->addMonth(),
            ]);

            $password = null;

            if ($request->assignment_type === 'existing') {
                // Assign existing user
                $user = User::findOrFail($validated['existing_user_id']);
                $user->update([
                    'company_id' => $company->id,
                    'role' => 'company_admin'
                ]);

                $message = "✅ Company created successfully! {$user->name} assigned as admin.";
            } else {
                // Create new user
                $password = 'Cnc@' . Str::random(8);

                $user = User::create([
                    'name' => $validated['admin_name'],
                    'email' => $validated['admin_email'],
                    'password' => Hash::make($password),
                    'role' => 'company_admin',
                    'company_id' => $company->id,
                ]);

                $message = "✅ Company & Admin created successfully!";
            }

            return redirect()->route('superadmin.companies.index')
                ->with('toast_success', $message)
                ->with('admin_credentials', [
                    'email' => $user->email,
                    'password' => $password
                ]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toast_error', '❌ Error creating company: ' . $e->getMessage());
        }
    }

    public function edit(Company $company)
    {
        $plans = Plan::where('is_active', true)->get();
        return view('backend.superadmin.companies.edit', compact('company', 'plans'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email,' . $company->id,
            'company_phone' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:500',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:active,trial,suspended',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date|after_or_equal:subscription_start',
        ], [
            'company_name.required' => 'Company name is required',
            'company_email.required' => 'Company email is required',
            'company_email.unique' => 'This company email already exists',
            'plan_id.required' => 'Please select a plan',
            'subscription_end.after_or_equal' => 'End date must be after or equal to start date',
        ]);

        try {
            $company->update([
                'name' => $request->company_name,
                'email' => $request->company_email,
                'phone' => $request->company_phone,
                'address' => $request->company_address,
                'plan_id' => $request->plan_id,
                'status' => $request->status,
                'subscription_start' => $request->subscription_start,
                'subscription_end' => $request->subscription_end,
            ]);

            return redirect()->route('superadmin.companies.index')
                ->with('toast_success', '✅ Company updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating company: ' . $e->getMessage());
        }
    }

    public function destroy(Company $company)
    {
        try {
            $companyName = $company->name;
            $company->delete(); // Soft delete

            return back()->with('toast_success', "✅ Company '{$companyName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting company: ' . $e->getMessage());
        }
    }
}
