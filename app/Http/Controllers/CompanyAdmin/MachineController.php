<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::where('company_id', Auth::user()->company_id)
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.machines.index', compact('machines'));
    }

    public function create()
    {
        return view('backend.companyadmin.machines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'machine_code' => 'required|string|unique:machines,machine_code|max:50',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'year_of_manufacture' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,maintenance,inactive,broken',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|integer|min:0',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date|after_or_equal:last_maintenance_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'machine_code.unique' => 'This machine code is already in use',
            'next_maintenance_date.after_or_equal' => 'Next maintenance date must be after or equal to last maintenance date',
        ]);

        try {
            $data = $request->except('image');
            $data['company_id'] = Auth::user()->company_id;

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('machines', 'public');
            }

            Machine::create($data);

            return redirect()->route('company.machines.index')
                ->with('toast_success', '✅ Machine created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating machine: ' . $e->getMessage());
        }
    }

    public function edit(Machine $machine)
    {
        // Check if machine belongs to user's company
        if ($machine->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        // Check if machine belongs to user's company
        if ($machine->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'machine_code' => 'required|string|max:50|unique:machines,machine_code,' . $machine->id,
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'year_of_manufacture' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,maintenance,inactive,broken',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|integer|min:0',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date|after_or_equal:last_maintenance_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->except('image');

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($machine->image) {
                    Storage::disk('public')->delete($machine->image);
                }
                $data['image'] = $request->file('image')->store('machines', 'public');
            }

            $machine->update($data);

            return redirect()->route('company.machines.index')
                ->with('toast_success', '✅ Machine updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating machine: ' . $e->getMessage());
        }
    }

    public function destroy(Machine $machine)
    {
        // Check if machine belongs to user's company
        if ($machine->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        try {
            $machineName = $machine->name;
            $machine->delete(); // Soft delete

            return back()->with('toast_success', "✅ Machine '{$machineName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting machine: ' . $e->getMessage());
        }
    }

    public function show(Machine $machine)
    {
        // Check if machine belongs to user's company
        if ($machine->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.machines.show', compact('machine'));
    }
}
