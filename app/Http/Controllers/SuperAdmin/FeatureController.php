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
            'name' => 'required',
            'slug' => 'required|unique:features,slug',
        ]);

        Feature::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.features.index')->with('success', 'Feature created successfully.');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Feature deleted.');
    }
}
