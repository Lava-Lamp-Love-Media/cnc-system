<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Debur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeburController extends Controller
{
    public function index()
    {
        $deburs = Debur::where('company_id', Auth::user()->company_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.companyadmin.deburs.index', compact('deburs'));
    }

    public function create()
    {
        return view('backend.companyadmin.deburs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'debur_code' => 'required|string|unique:deburs,debur_code|max:50',
            'name' => 'required|string|max:255',
            'size' => 'nullable|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            Debur::create([
                'company_id' => Auth::user()->company_id,
                'debur_code' => $request->debur_code,
                'name' => $request->name,
                'size' => $request->size,
                'unit_price' => $request->unit_price,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.deburs.index')
                ->with('toast_success', '✅ Debur created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Debur creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating debur: ' . $e->getMessage());
        }
    }

    public function show(Debur $debur)
    {
        if ($debur->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.deburs.show', compact('debur'));
    }

    public function edit(Debur $debur)
    {
        if ($debur->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.deburs.edit', compact('debur'));
    }

    public function update(Request $request, Debur $debur)
    {
        if ($debur->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'debur_code' => 'required|string|max:50|unique:deburs,debur_code,' . $debur->id,
            'name' => 'required|string|max:255',
            'size' => 'nullable|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $debur->update($request->all());

            DB::commit();

            return redirect()->route('company.deburs.index')
                ->with('toast_success', '✅ Debur updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Debur update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating debur: ' . $e->getMessage());
        }
    }

    public function destroy(Debur $debur)
    {
        if ($debur->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $deburName = $debur->name;
            $debur->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Debur '{$deburName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Debur deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting debur: ' . $e->getMessage());
        }
    }
}
