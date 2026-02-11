<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email|unique:companies,email',
            'plan_id' => 'required|exists:plans,id',
            'admin_name' => 'required',
            'admin_email' => 'required|email|unique:users,email',
        ]);

        // Create Company
        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
            'plan_id' => $request->plan_id,
            'status' => 'active'
        ]);

        // Generate password
        $plainPassword = Str::random(10);

        // Create Company Admin User
        User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($plainPassword),
            'role' => 'company_admin',
            'company_id' => $company->id
        ]);

        return redirect()->route('superadmin.companies.index')
            ->with('success', 'Company & Admin created successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Company deleted.');
    }
}
