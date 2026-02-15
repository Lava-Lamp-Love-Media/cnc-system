<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TapController extends Controller
{
    public function index()
    {
        $taps = Tap::where('company_id', Auth::user()->company_id)
            ->orderBy('sort_order')
            ->orderBy('diameter')
            ->paginate(15);

        return view('backend.companyadmin.taps.index', compact('taps'));
    }

    public function create()
    {
        return view('backend.companyadmin.taps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tap_code' => 'required|string|unique:taps,tap_code|max:50',
            'name' => 'required|string|max:255',
            'diameter' => 'required|numeric|min:0',
            'pitch' => 'required|numeric|min:0',
            'thread_standard' => 'required|string|max:50',
            'thread_class' => 'nullable|string|max:50',
            'direction' => 'required|in:right,left',
            'thread_sizes' => 'nullable|array',
            'thread_options' => 'nullable|array',
            'tap_price' => 'required|numeric|min:0',
            'thread_option_price' => 'nullable|numeric|min:0',
            'pitch_price' => 'nullable|numeric|min:0',
            'class_price' => 'nullable|numeric|min:0',
            'size_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            Tap::create([
                'company_id' => Auth::user()->company_id,
                'tap_code' => $request->tap_code,
                'name' => $request->name,
                'diameter' => $request->diameter,
                'pitch' => $request->pitch,
                'thread_standard' => $request->thread_standard,
                'thread_class' => $request->thread_class,
                'direction' => $request->direction,
                'thread_sizes' => $request->thread_sizes,
                'thread_options' => $request->thread_options,
                'tap_price' => $request->tap_price,
                'thread_option_price' => $request->thread_option_price ?? 0,
                'pitch_price' => $request->pitch_price ?? 0,
                'class_price' => $request->class_price ?? 0,
                'size_price' => $request->size_price ?? 0,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.taps.index')
                ->with('toast_success', '✅ Tap created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tap creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating tap: ' . $e->getMessage());
        }
    }

    public function show(Tap $tap)
    {
        if ($tap->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.taps.show', compact('tap'));
    }

    public function edit(Tap $tap)
    {
        if ($tap->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.taps.edit', compact('tap'));
    }

    public function update(Request $request, Tap $tap)
    {
        if ($tap->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'tap_code' => 'required|string|max:50|unique:taps,tap_code,' . $tap->id,
            'name' => 'required|string|max:255',
            'diameter' => 'required|numeric|min:0',
            'pitch' => 'required|numeric|min:0',
            'thread_standard' => 'required|string|max:50',
            'thread_class' => 'nullable|string|max:50',
            'direction' => 'required|in:right,left',
            'thread_sizes' => 'nullable|array',
            'thread_options' => 'nullable|array',
            'tap_price' => 'required|numeric|min:0',
            'thread_option_price' => 'nullable|numeric|min:0',
            'pitch_price' => 'nullable|numeric|min:0',
            'class_price' => 'nullable|numeric|min:0',
            'size_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $tap->update($request->all());

            DB::commit();

            return redirect()->route('company.taps.index')
                ->with('toast_success', '✅ Tap updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tap update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating tap: ' . $e->getMessage());
        }
    }

    public function destroy(Tap $tap)
    {
        if ($tap->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $tapName = $tap->name;
            $tap->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Tap '{$tapName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tap deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting tap: ' . $e->getMessage());
        }
    }
}
