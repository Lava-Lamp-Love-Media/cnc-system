<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('features')->latest()->paginate(10);
        return view('backend.superadmin.plans.index', compact('plans'));
    }

    public function create()
    {
        $features = Feature::where('is_active', true)->get();
        return view('backend.superadmin.plans.create', compact('features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:plans,slug',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
        ]);

        $plan = Plan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'is_active' => true,
        ]);

        if ($request->features) {
            $plan->features()->sync($request->features);
        }

        return redirect()->route('superadmin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back()->with('success', 'Plan deleted.');
    }
}
