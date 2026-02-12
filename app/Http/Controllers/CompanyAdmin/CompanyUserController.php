<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyUserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isCompanyAdmin()) {
            abort(403, 'Unauthorized');
        }

        $users = auth()->user()->company->users()
            ->where('role', 'user')
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isCompanyAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('backend.companyadmin.users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isCompanyAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $password = 'Cnc@' . Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'user',
            'company_id' => auth()->user()->company_id,
        ]);

        return redirect()->route('company.users.index')
            ->with('success', "User created! Login: {$user->email} / {$password}");
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isCompanyAdmin() || $user->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}
