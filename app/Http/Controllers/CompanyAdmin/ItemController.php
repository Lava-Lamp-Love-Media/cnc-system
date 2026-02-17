<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $items = Item::where('company_id', $companyId)
            ->with(['warehouse'])
            ->latest()
            ->paginate(20);

        return view('backend.companyadmin.items.index', compact('items'));
    }

    public function create()
    {
        $companyId = auth()->user()->company_id;
        $warehouses = Warehouse::where('company_id', $companyId)->get();

        return view('backend.companyadmin.items.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:items,sku',
            'class' => 'required|in:tooling,sellable,raw_stock,consommable',
            'unit' => 'required|in:each,kg,lb,meter,foot,liter,gallon',
            'count' => 'nullable|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'stock_min' => 'nullable|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_inventory' => 'nullable|boolean',
            'is_taxable' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['company_id'] = auth()->user()->company_id;
        $validated['is_inventory'] = $request->has('is_inventory');
        $validated['is_taxable'] = $request->has('is_taxable');
        $validated['current_stock'] = $validated['count'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($validated);

        // Check if request wants JSON (AJAX request)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item created successfully!',
                'item' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'unit' => $item->unit,
                    'cost_price' => $item->cost_price,
                ]
            ]);
        }

        return redirect()->route('company.items.index')
            ->with('toast_success', 'Item created successfully!');
    }

    public function show(Item $item)
    {
        $this->authorize('view', $item);

        $item->load(['warehouse', 'inventoryTransactions' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('backend.companyadmin.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);

        $companyId = auth()->user()->company_id;
        $warehouses = Warehouse::where('company_id', $companyId)->get();

        return view('backend.companyadmin.items.edit', compact('item', 'warehouses'));
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:items,sku,' . $item->id,
            'class' => 'required|in:tooling,sellable,raw_stock,consommable',
            'unit' => 'required|in:each,kg,lb,meter,foot,liter,gallon',
            'count' => 'nullable|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'stock_min' => 'nullable|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_inventory' => 'nullable|boolean',
            'is_taxable' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_inventory'] = $request->has('is_inventory');
        $validated['is_taxable'] = $request->has('is_taxable');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('company.items.index')
            ->with('toast_success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        // Delete image
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('company.items.index')
            ->with('toast_success', 'Item deleted successfully!');
    }
}
