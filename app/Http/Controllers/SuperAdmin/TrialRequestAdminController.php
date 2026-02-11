<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TrialRequest;
use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrialRequestAdminController extends Controller
{
    public function index()
    {
        $requests = TrialRequest::latest()->paginate(15);
        return view('backend.superadmin.trial_requests.index', compact('requests'));
    }

    public function approve(TrialRequest $trialRequest)
    {
        if ($trialRequest->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        // Pick plan by preferred slug; fallback to first active plan
        $plan = null;
        if ($trialRequest->preferred_plan_slug) {
            $plan = Plan::where('slug', $trialRequest->preferred_plan_slug)->first();
        }
        if (!$plan) {
            $plan = Plan::where('is_active', true)->orderBy('id')->first();
        }
        if (!$plan) {
            return back()->with('error', 'No active plan found. Create a plan first.');
        }

        // Create company
        $company = Company::create([
            'name' => $trialRequest->company_name,
            'email' => $trialRequest->company_email,
            'phone' => $trialRequest->phone,
            'status' => 'trial',
            'plan_id' => $plan->id,
            'subscription_start' => now()->toDateString(),
            'subscription_end' => now()->addDays($plan->duration_days ?? 30)->toDateString(),
        ]);

        // Create company admin user
        $plainPassword = 'Cnc@' . Str::random(10);

        $adminUser = User::create([
            'name' => $trialRequest->contact_name,
            'email' => $trialRequest->contact_email,
            'password' => Hash::make($plainPassword),
            'role' => 'company_admin',
            'company_id' => $company->id,
        ]);

        // Update request
        $trialRequest->update([
            'status' => 'approved',
            'company_id' => $company->id,
            'approved_at' => now(),
        ]);

        // 🔜 Later: send credentials via mail/queue
        // Mail::to($adminUser->email)->queue(new CompanyCredentialsMail($adminUser, $plainPassword));

        return back()->with('success', "Approved! Admin created: {$adminUser->email} / {$plainPassword}");
    }

    public function reject(TrialRequest $trialRequest)
    {
        if ($trialRequest->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $trialRequest->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Request rejected.');
    }
}
