<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\InventoryTransaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $items = Item::where('company_id', $companyId)
            ->where('is_inventory', true)
            ->with(['warehouse'])
            ->get();

        $lowStockItems = $items->filter(function ($item) {
            return $item->isLowStock();
        });

        return view('backend.companyadmin.inventory.index', compact('items', 'lowStockItems'));
    }

    public function transactions()
    {
        $companyId = auth()->user()->company_id;

        $transactions = InventoryTransaction::where('company_id', $companyId)
            ->with(['item', 'warehouse', 'createdBy'])
            ->latest()
            ->paginate(50);

        return view('backend.companyadmin.inventory.transactions', compact('transactions'));
    }

    public function adjust(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:add,subtract',
            'notes' => 'nullable|string',
        ]);

        $quantityBefore = $item->current_stock;

        if ($validated['type'] === 'add') {
            $item->updateStock($validated['quantity'], 'add');
            $quantity = $validated['quantity'];
        } else {
            $item->updateStock($validated['quantity'], 'subtract');
            $quantity = -$validated['quantity'];
        }

        // Create inventory transaction
        InventoryTransaction::create([
            'company_id' => $item->company_id,
            'item_id' => $item->id,
            'warehouse_id' => $item->warehouse_id,
            'type' => 'adjustment',
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $item->current_stock,
            'unit_price' => $item->cost_price,
            'notes' => $validated['notes'] ?? 'Manual adjustment',
            'created_by' => auth()->id(),
        ]);

        return back()->with('toast_success', 'Inventory adjusted successfully!');
    }
}
