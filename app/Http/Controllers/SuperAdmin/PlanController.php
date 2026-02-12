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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:plans,slug|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ], [
            'name.required' => 'Plan name is required',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'This slug already exists',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'duration_days.required' => 'Duration is required',
        ]);

        try {
            $plan = Plan::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug, '_'),
                'price' => $request->price,
                'duration_days' => $request->duration_days,
                'is_active' => true,
            ]);

            if ($request->features) {
                $plan->features()->sync($request->features);
            }

            return redirect()->route('superadmin.plans.index')
                ->with('toast_success', '✅ Plan created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating plan: ' . $e->getMessage());
        }
    }

    public function edit(Plan $plan)
    {
        $features = Feature::where('is_active', true)->get();
        return view('backend.superadmin.plans.edit', compact('plan', 'features'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'features' => 'nullable|array',
        ]);

        try {
            $plan->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug, '_'),
                'price' => $request->price,
                'duration_days' => $request->duration_days,
                'is_active' => $request->is_active,
            ]);

            $plan->features()->sync($request->features ?? []);

            return redirect()->route('superadmin.plans.index')
                ->with('toast_success', '✅ Plan updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating plan: ' . $e->getMessage());
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            $planName = $plan->name;
            $plan->delete(); // Soft delete

            return back()->with('toast_success', "✅ Plan '{$planName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting plan: ' . $e->getMessage());
        }
    }
}
