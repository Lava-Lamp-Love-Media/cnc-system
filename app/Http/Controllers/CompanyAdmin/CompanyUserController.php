<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyUserController extends Controller
{
    private function ensureCompanyAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isCompanyAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    private function companyId(): int
    {
        return (int) auth()->user()->company_id;
    }

    // Allowed roles for company admin to assign
    private function allowedRoles(): array
    {
        return ['user', 'shop', 'engineer', 'editor', 'qc', 'checker'];
        // If you want to allow creating another company_admin:
        // return ['user','shop','engineer','editor','qc','checker','company_admin'];
    }

    private function ensureSameCompany(User $user): void
    {
        if ((int) $user->company_id !== $this->companyId()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->ensureCompanyAdmin();

        $users = User::query()
            ->where('company_id', $this->companyId())
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.users.index', compact('users'));
    }

    public function create()
    {
        $this->ensureCompanyAdmin();

        $roles = $this->allowedRoles();
        return view('backend.companyadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->ensureCompanyAdmin();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'role'  => ['required', Rule::in($this->allowedRoles())],
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'This email already exists',
            'role.required' => 'Role is required',
        ]);

        try {
            $passwordPlain = 'Cnc@' . Str::random(10);

            $user = User::create([
                'company_id' => $this->companyId(),
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'role'       => $validated['role'],
                'password'   => Hash::make($passwordPlain),
            ]);

            // Use your existing popup in layouts.app (admin_credentials)
            return redirect()->route('company.users.index')
                ->with('toast_success', '✅ User created successfully!')
                ->with('admin_credentials', [
                    'email' => $user->email,
                    'password' => $passwordPlain,
                ]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $this->ensureCompanyAdmin();
        $this->ensureSameCompany($user);

        $roles = $this->allowedRoles();
        return view('backend.companyadmin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->ensureCompanyAdmin();
        $this->ensureSameCompany($user);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:190',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in($this->allowedRoles())],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('company.users.index')
                ->with('toast_success', '✅ User updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $this->ensureCompanyAdmin();
        $this->ensureSameCompany($user);

        if ($user->id === auth()->id()) {
            return back()->with('toast_warning', '⚠️ You cannot delete your own account.');
        }

        try {
            $name = $user->name;
            $user->delete(); // soft delete (if SoftDeletes enabled)

            return back()->with('toast_success', "✅ User '{$name}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting user: ' . $e->getMessage());
        }
    }
}
