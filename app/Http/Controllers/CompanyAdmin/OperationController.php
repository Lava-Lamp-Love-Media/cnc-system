<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    public function index()
    {
        $operations = Operation::where('company_id', Auth::user()->company_id)
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.operations.index', compact('operations'));
    }

    public function create()
    {
        return view('backend.companyadmin.operations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'operation_code' => 'required|string|unique:operations,operation_code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'operation_code.unique' => 'This operation code is already in use',
        ]);

        try {
            Operation::create([
                'company_id' => Auth::user()->company_id,
                'operation_code' => $request->operation_code,
                'name' => $request->name,
                'description' => $request->description,
                'hourly_rate' => $request->hourly_rate,
                'status' => $request->status,
            ]);

            return redirect()->route('company.operations.index')
                ->with('toast_success', '✅ Operation created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating operation: ' . $e->getMessage());
        }
    }

    public function show(Operation $operation)
    {
        // Check if operation belongs to user's company
        if ($operation->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.operations.show', compact('operation'));
    }

    public function edit(Operation $operation)
    {
        // Check if operation belongs to user's company
        if ($operation->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.operations.edit', compact('operation'));
    }

    public function update(Request $request, Operation $operation)
    {
        // Check if operation belongs to user's company
        if ($operation->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'operation_code' => 'required|string|max:50|unique:operations,operation_code,' . $operation->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $operation->update($request->all());

            return redirect()->route('company.operations.index')
                ->with('toast_success', '✅ Operation updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating operation: ' . $e->getMessage());
        }
    }

    public function destroy(Operation $operation)
    {
        // Check if operation belongs to user's company
        if ($operation->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        try {
            $operationName = $operation->name;
            $operation->delete(); // Soft delete

            return back()->with('toast_success', "✅ Operation '{$operationName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting operation: ' . $e->getMessage());
        }
    }
}
