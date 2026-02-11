<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TrialRequest;
use Illuminate\Http\Request;

class TrialRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'plan_slug' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:3000',
        ]);

        TrialRequest::create([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'phone' => $request->phone,
            'preferred_plan_slug' => $request->plan_slug,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('trial.success');
    }
}
