<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::where('company_id', Auth::user()->company_id)
            ->orderBy('thread_type')
            ->orderBy('sort_order')
            ->orderBy('diameter')
            ->paginate(15);

        return view('backend.companyadmin.threads.index', compact('threads'));
    }

    public function create()
    {
        return view('backend.companyadmin.threads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'thread_code' => 'required|string|unique:threads,thread_code|max:50',
            'name' => 'required|string|max:255',
            'thread_type' => 'required|in:external,internal',
            'diameter' => 'required|numeric|min:0',
            'pitch' => 'required|numeric|min:0',
            'thread_standard' => 'required|string|max:50',
            'thread_class' => 'nullable|string|max:50',
            'direction' => 'required|in:right,left',
            'thread_sizes' => 'nullable|array',
            'thread_options' => 'nullable|array',
            'thread_price' => 'required|numeric|min:0',
            'option_price' => 'nullable|numeric|min:0',
            'pitch_price' => 'nullable|numeric|min:0',
            'class_price' => 'nullable|numeric|min:0',
            'size_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            Thread::create([
                'company_id' => Auth::user()->company_id,
                'thread_code' => $request->thread_code,
                'name' => $request->name,
                'thread_type' => $request->thread_type,
                'diameter' => $request->diameter,
                'pitch' => $request->pitch,
                'thread_standard' => $request->thread_standard,
                'thread_class' => $request->thread_class,
                'direction' => $request->direction,
                'thread_sizes' => $request->thread_sizes,
                'thread_options' => $request->thread_options,
                'thread_price' => $request->thread_price,
                'option_price' => $request->option_price ?? 0,
                'pitch_price' => $request->pitch_price ?? 0,
                'class_price' => $request->class_price ?? 0,
                'size_price' => $request->size_price ?? 0,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('company.threads.index')
                ->with('toast_success', '✅ Thread created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thread creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating thread: ' . $e->getMessage());
        }
    }

    public function show(Thread $thread)
    {
        if ($thread->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        if ($thread->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('backend.companyadmin.threads.edit', compact('thread'));
    }

    public function update(Request $request, Thread $thread)
    {
        if ($thread->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'thread_code' => 'required|string|max:50|unique:threads,thread_code,' . $thread->id,
            'name' => 'required|string|max:255',
            'thread_type' => 'required|in:external,internal',
            'diameter' => 'required|numeric|min:0',
            'pitch' => 'required|numeric|min:0',
            'thread_standard' => 'required|string|max:50',
            'thread_class' => 'nullable|string|max:50',
            'direction' => 'required|in:right,left',
            'thread_sizes' => 'nullable|array',
            'thread_options' => 'nullable|array',
            'thread_price' => 'required|numeric|min:0',
            'option_price' => 'nullable|numeric|min:0',
            'pitch_price' => 'nullable|numeric|min:0',
            'class_price' => 'nullable|numeric|min:0',
            'size_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $thread->update($request->all());

            DB::commit();

            return redirect()->route('company.threads.index')
                ->with('toast_success', '✅ Thread updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thread update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating thread: ' . $e->getMessage());
        }
    }

    public function destroy(Thread $thread)
    {
        if ($thread->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $threadName = $thread->name;
            $thread->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Thread '{$threadName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thread deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting thread: ' . $e->getMessage());
        }
    }
}
