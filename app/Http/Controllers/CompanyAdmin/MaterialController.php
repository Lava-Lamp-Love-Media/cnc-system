<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::where('company_id', Auth::user()->company_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.companyadmin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('backend.companyadmin.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_code' => 'required|string|unique:materials,material_code|max:50',
            'name'          => 'required|string|max:255',
            'type'          => 'required|in:metal_alloy,plastic,composite,other',
            'unit'          => 'required|in:mm,inch',
            'diameter_from' => 'required|numeric|min:0',
            'diameter_to'   => 'required|numeric|min:0|gte:diameter_from',
            'price'         => 'required|numeric|min:0',
            'adj'           => 'nullable|numeric',
            'adj_type'      => 'required|in:amount,percent',
            'density'       => 'required|numeric|min:0',
            'code'          => 'nullable|string|max:20',
            'sort_order'    => 'nullable|integer|min:0',
            'status'        => 'required|in:active,inactive',
            'notes'         => 'nullable|string|max:1000',
        ], [
            'material_code.required' => 'Material code is required',
            'material_code.unique'   => 'This material code already exists',
            'name.required'          => 'Material name is required',
            'diameter_to.gte'        => 'Diameter To must be greater than or equal to Diameter From',
        ]);

        DB::beginTransaction();

        try {
            Material::create([
                'company_id'    => Auth::user()->company_id,
                'material_code' => $request->material_code,
                'name'          => $request->name,
                'type'          => $request->type,
                'unit'          => $request->unit,
                'diameter_from' => $request->diameter_from,
                'diameter_to'   => $request->diameter_to,
                'price'         => $request->price,
                'adj'           => $request->adj ?? 0,
                'adj_type'      => $request->adj_type,
                'density'       => $request->density,
                'code'          => $request->code,
                'sort_order'    => $request->sort_order ?? 0,
                'status'        => $request->status,
                'notes'         => $request->notes,
            ]);

            DB::commit();

            return redirect()->route('company.materials.index')
                ->with('toast_success', '✅ Material created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Material creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating material: ' . $e->getMessage());
        }
    }

    public function show(Material $material)
    {
        if ($material->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        if ($material->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        if ($material->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'material_code' => 'required|string|max:50|unique:materials,material_code,' . $material->id,
            'name'          => 'required|string|max:255',
            'type'          => 'required|in:metal_alloy,plastic,composite,other',
            'unit'          => 'required|in:mm,inch',
            'diameter_from' => 'required|numeric|min:0',
            'diameter_to'   => 'required|numeric|min:0|gte:diameter_from',
            'price'         => 'required|numeric|min:0',
            'adj'           => 'nullable|numeric',
            'adj_type'      => 'required|in:amount,percent',
            'density'       => 'required|numeric|min:0',
            'code'          => 'nullable|string|max:20',
            'sort_order'    => 'nullable|integer|min:0',
            'status'        => 'required|in:active,inactive',
            'notes'         => 'nullable|string|max:1000',
        ], [
            'diameter_to.gte' => 'Diameter To must be greater than or equal to Diameter From',
        ]);

        DB::beginTransaction();

        try {
            $material->update([
                'material_code' => $request->material_code,
                'name'          => $request->name,
                'type'          => $request->type,
                'unit'          => $request->unit,
                'diameter_from' => $request->diameter_from,
                'diameter_to'   => $request->diameter_to,
                'price'         => $request->price,
                'adj'           => $request->adj ?? 0,
                'adj_type'      => $request->adj_type,
                'density'       => $request->density,
                'code'          => $request->code,
                'sort_order'    => $request->sort_order ?? 0,
                'status'        => $request->status,
                'notes'         => $request->notes,
            ]);

            DB::commit();

            return redirect()->route('company.materials.index')
                ->with('toast_success', '✅ Material updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Material update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating material: ' . $e->getMessage());
        }
    }

    public function destroy(Material $material)
    {
        if ($material->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $materialName = $material->name;
            $material->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Material '{$materialName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Material deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting material: ' . $e->getMessage());
        }
    }

    // AJAX — active materials for quote form selects
    public function ajaxList(Request $request)
    {
        $materials = Material::where('company_id', Auth::user()->company_id)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'unit', 'price', 'adj', 'adj_type', 'real_price', 'density', 'diameter_from', 'diameter_to', 'code']);

        return response()->json($materials);
    }
}
