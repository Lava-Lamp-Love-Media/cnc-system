<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Hole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HoleController extends Controller
{
    public function index()
    {
        $holes = Hole::where('company_id', Auth::user()->company_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.companyadmin.holes.index', compact('holes'));
    }

    public function create()
    {
        return view('backend.companyadmin.holes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hole_code' => 'required|string|unique:holes,hole_code|max:50',
            'name' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'hole_type' => 'required|in:through,blind,countersink,counterbore',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'hole_code.required' => 'Hole code is required',
            'hole_code.unique' => 'This hole code already exists',
            'name.required' => 'Hole name is required',
            'size.required' => 'Hole size is required',
            'hole_type.required' => 'Hole type is required',
            'unit_price.required' => 'Unit price is required',
        ]);

        DB::beginTransaction();

        try {
            Hole::create([
                'company_id' => Auth::user()->company_id,
                'hole_code' => $request->hole_code,
                'name' => $request->name,
                'size' => $request->size,
                'hole_type' => $request->hole_type,
                'unit_price' => $request->unit_price,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.holes.index')
                ->with('toast_success', '✅ Hole created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hole creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating hole: ' . $e->getMessage());
        }
    }

    public function show(Hole $hole)
    {
        if ($hole->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.holes.show', compact('hole'));
    }

    public function edit(Hole $hole)
    {
        if ($hole->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.holes.edit', compact('hole'));
    }

    public function update(Request $request, Hole $hole)
    {
        if ($hole->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'hole_code' => 'required|string|max:50|unique:holes,hole_code,' . $hole->id,
            'name' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'hole_type' => 'required|in:through,blind,countersink,counterbore',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $hole->update([
                'hole_code' => $request->hole_code,
                'name' => $request->name,
                'size' => $request->size,
                'hole_type' => $request->hole_type,
                'unit_price' => $request->unit_price,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.holes.index')
                ->with('toast_success', '✅ Hole updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hole update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating hole: ' . $e->getMessage());
        }
    }

    public function destroy(Hole $hole)
    {
        if ($hole->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $holeName = $hole->name;
            $hole->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Hole '{$holeName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hole deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting hole: ' . $e->getMessage());
        }
    }
}
