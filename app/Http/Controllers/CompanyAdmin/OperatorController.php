<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = Operator::where('company_id', Auth::user()->company_id)
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.operators.index', compact('operators'));
    }

    public function create()
    {
        return view('backend.companyadmin.operators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'operator_code' => 'required|string|unique:operators,operator_code|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'skill_level' => 'required|in:trainee,junior,senior,expert',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ], [
            'operator_code.unique' => 'This operator code is already in use',
        ]);

        try {
            Operator::create([
                'company_id' => Auth::user()->company_id,
                'operator_code' => $request->operator_code,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'skill_level' => $request->skill_level,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            return redirect()->route('company.operators.index')
                ->with('toast_success', '✅ Operator created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error creating operator: ' . $e->getMessage());
        }
    }

    public function show(Operator $operator)
    {
        // Check if operator belongs to user's company
        if ($operator->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.operators.show', compact('operator'));
    }

    public function edit(Operator $operator)
    {
        // Check if operator belongs to user's company
        if ($operator->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        return view('backend.companyadmin.operators.edit', compact('operator'));
    }

    public function update(Request $request, Operator $operator)
    {
        // Check if operator belongs to user's company
        if ($operator->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'operator_code' => 'required|string|max:50|unique:operators,operator_code,' . $operator->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'skill_level' => 'required|in:trainee,junior,senior,expert',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $operator->update($request->all());

            return redirect()->route('company.operators.index')
                ->with('toast_success', '✅ Operator updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast_error', '❌ Error updating operator: ' . $e->getMessage());
        }
    }

    public function destroy(Operator $operator)
    {
        // Check if operator belongs to user's company
        if ($operator->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        try {
            $operatorName = $operator->name;
            $operator->delete(); // Soft delete

            return back()->with('toast_success', "✅ Operator '{$operatorName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('toast_error', '❌ Error deleting operator: ' . $e->getMessage());
        }
    }
}
