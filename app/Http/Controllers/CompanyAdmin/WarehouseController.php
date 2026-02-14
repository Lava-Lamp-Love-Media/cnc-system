<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::where('company_id', Auth::user()->company_id)
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('backend.companyadmin.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_code' => 'required|string|unique:warehouses,warehouse_code|max:50',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'storage_capacity' => 'nullable|numeric|min:0',
            'capacity_unit' => 'required|in:sqm,cbm',
            'warehouse_type' => 'required|in:main,secondary,raw_material,finished_goods,tools',
            'status' => 'required|in:active,inactive,maintenance',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ], [
            'warehouse_code.unique' => 'This warehouse code is already in use',
        ]);

        try {
            Warehouse::create([
                'company_id' => Auth::user()->company_id,
                'warehouse_code' => $request->warehouse_code,
                'name' => $request->name,
                'location' => $request->location,
                'manager_name' => $request->manager_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'storage_capacity' => $request->storage_capacity,
                'capacity_unit' => $request->capacity_unit,
                'warehouse_type' => $request->warehouse_type,
                'status' => $request->status,
                'description' => $request->description,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            return redirect()->route('company.warehouses.index')
                ->with('toast_success', '✅ Warehouse created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating warehouse: ' . $e->getMessage());
        }
    }

    public function show(Warehouse $warehouse)
    {
        // Check if warehouse belongs to user's company
        if ($warehouse->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        // Check if warehouse belongs to user's company
        if ($warehouse->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        // Check if warehouse belongs to user's company
        if ($warehouse->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'warehouse_code' => 'required|string|max:50|unique:warehouses,warehouse_code,' . $warehouse->id,
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'storage_capacity' => 'nullable|numeric|min:0',
            'capacity_unit' => 'required|in:sqm,cbm',
            'warehouse_type' => 'required|in:main,secondary,raw_material,finished_goods,tools',
            'status' => 'required|in:active,inactive,maintenance',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        try {
            $warehouse->update($request->all());

            return redirect()->route('company.warehouses.index')
                ->with('toast_success', '✅ Warehouse updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating warehouse: ' . $e->getMessage());
        }
    }

    public function destroy(Warehouse $warehouse)
    {
        // Check if warehouse belongs to user's company
        if ($warehouse->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        try {
            $warehouseName = $warehouse->name;
            $warehouse->delete(); // Soft delete

            return back()->with('toast_success', "✅ Warehouse '{$warehouseName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting warehouse: ' . $e->getMessage());
        }
    }
}
