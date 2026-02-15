<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chamfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChamferController extends Controller
{
    public function index()
    {
        $chamfers = Chamfer::where('company_id', Auth::user()->company_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.companyadmin.chamfers.index', compact('chamfers'));
    }

    public function create()
    {
        return view('backend.companyadmin.chamfers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'chamfer_code' => 'required|string|unique:chamfers,chamfer_code|max:50',
            'name' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'angle' => 'nullable|numeric|min:0|max:180',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            Chamfer::create([
                'company_id' => Auth::user()->company_id,
                'chamfer_code' => $request->chamfer_code,
                'name' => $request->name,
                'size' => $request->size,
                'angle' => $request->angle,
                'unit_price' => $request->unit_price,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.chamfers.index')
                ->with('toast_success', '✅ Chamfer created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Chamfer creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating chamfer: ' . $e->getMessage());
        }
    }

    public function show(Chamfer $chamfer)
    {
        if ($chamfer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.chamfers.show', compact('chamfer'));
    }

    public function edit(Chamfer $chamfer)
    {
        if ($chamfer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.chamfers.edit', compact('chamfer'));
    }

    public function update(Request $request, Chamfer $chamfer)
    {
        if ($chamfer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'chamfer_code' => 'required|string|max:50|unique:chamfers,chamfer_code,' . $chamfer->id,
            'name' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'angle' => 'nullable|numeric|min:0|max:180',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $chamfer->update($request->all());

            DB::commit();

            return redirect()->route('company.chamfers.index')
                ->with('toast_success', '✅ Chamfer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Chamfer update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating chamfer: ' . $e->getMessage());
        }
    }

    public function destroy(Chamfer $chamfer)
    {
        if ($chamfer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $chamferName = $chamfer->name;
            $chamfer->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Chamfer '{$chamferName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Chamfer deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting chamfer: ' . $e->getMessage());
        }
    }
}
