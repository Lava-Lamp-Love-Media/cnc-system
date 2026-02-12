<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::latest()->paginate(10);
        return view('backend.superadmin.features.index', compact('features'));
    }

    public function create()
    {
        return view('backend.superadmin.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:features,slug|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Feature name is required',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'This slug already exists',
        ]);

        try {
            Feature::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug, '_'),
                'description' => $request->description,
                'is_active' => true,
            ]);

            return redirect()->route('superadmin.features.index')
                ->with('toast_success', '✅ Feature created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating feature: ' . $e->getMessage());
        }
    }

    public function edit(Feature $feature)
    {
        return view('backend.superadmin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:features,slug,' . $feature->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
        ]);

        try {
            $feature->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug, '_'),
                'description' => $request->description,
                'is_active' => $request->is_active,
            ]);

            return redirect()->route('superadmin.features.index')
                ->with('toast_success', '✅ Feature updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating feature: ' . $e->getMessage());
        }
    }

    public function destroy(Feature $feature)
    {
        try {
            $featureName = $feature->name;
            $feature->delete(); // Soft delete only

            return back()->with('toast_success', "✅ Feature '{$featureName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting feature: ' . $e->getMessage());
        }
    }
}
