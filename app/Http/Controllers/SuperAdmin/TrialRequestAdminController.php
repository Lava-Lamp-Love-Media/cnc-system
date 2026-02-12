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
        // Show pending first, then approved/rejected
        $requests = TrialRequest::orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15);

        return view('backend.superadmin.trial_requests.index', compact('requests'));
    }

    public function approve(TrialRequest $trialRequest)
    {
        if ($trialRequest->status !== 'pending') {
            return back()->with('toast_error', '❌ This request is already processed.');
        }

        try {
            // Pick plan by preferred slug; fallback to first active plan
            $plan = null;
            if ($trialRequest->preferred_plan_slug) {
                $plan = Plan::where('slug', $trialRequest->preferred_plan_slug)->first();
            }
            if (!$plan) {
                $plan = Plan::where('is_active', true)->orderBy('id')->first();
            }
            if (!$plan) {
                return back()->with('toast_error', '❌ No active plan found. Create a plan first.');
            }

            // Create company
            $company = Company::create([
                'name' => $trialRequest->company_name,
                'email' => $trialRequest->company_email,
                'phone' => $trialRequest->phone,
                'status' => 'trial',
                'plan_id' => $plan->id,
                'subscription_start' => now(),
                'subscription_end' => now()->addDays($plan->duration_days ?? 30),
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

            // Show credentials
            return back()
                ->with('toast_success', "✅ Trial approved! Company '{$company->name}' created successfully!")
                ->with('admin_credentials', [
                    'email' => $adminUser->email,
                    'password' => $plainPassword
                ]);
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error approving request: ' . $e->getMessage());
        }
    }

    public function reject(TrialRequest $trialRequest)
    {
        if ($trialRequest->status !== 'pending') {
            return back()->with('toast_error', '❌ This request is already processed.');
        }

        try {
            $trialRequest->update([
                'status' => 'rejected',
            ]);

            return back()->with('toast_success', '✅ Request rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error rejecting request: ' . $e->getMessage());
        }
    }
}
