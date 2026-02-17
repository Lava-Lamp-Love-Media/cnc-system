<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrderAttachment;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $purchaseOrders = PurchaseOrder::where('company_id', $companyId)
            ->with(['vendor', 'warehouse'])
            ->latest()
            ->paginate(20);

        return view('backend.companyadmin.purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $companyId = auth()->user()->company_id;
        $vendors = Vendor::where('company_id', $companyId)->get();
        $items = Item::where('company_id', $companyId)->get();
        $warehouses = Warehouse::where('company_id', $companyId)->get();

        $poNumber = PurchaseOrder::generatePONumber($companyId);

        return view('backend.companyadmin.purchase-orders.create', compact('vendors', 'items', 'warehouses', 'poNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'po_number' => 'required|string|unique:purchase_orders,po_number',
            'type' => 'required|in:draft,first_article,production',
            'order_date' => 'required|date',
            'expected_received_date' => 'nullable|date',
            'payment_terms' => 'nullable|string',
            'ship_to' => 'nullable|string',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'cage_number' => 'nullable|string',
            'discount_type' => 'required|in:flat,percentage',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'current_stock_level' => 'nullable|string',
            'purchase_level' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_type' => 'required|in:flat,percentage',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.taxable' => 'nullable|boolean',
            'items.*.inventory' => 'nullable|boolean',
            'items.*.notes' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,dwg,dxf|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $validated['company_id'] = auth()->user()->company_id;
            $validated['status'] = 'draft';

            // Create Purchase Order
            $purchaseOrder = PurchaseOrder::create($validated);

            // Create Purchase Order Items
            foreach ($request->items as $itemData) {
                $item = Item::find($itemData['item_id']);

                $poItem = new PurchaseOrderItem([
                    'item_id' => $item->id,
                    'item_sku' => $item->sku,
                    'count_of' => $itemData['count_of'] ?? 1,
                    'unit' => $itemData['unit'] ?? $item->unit,
                    'count_price' => $itemData['count_price'] ?? 0,
                    'unit_price' => $itemData['unit_price'],
                    'quantity' => $itemData['quantity'],
                    'notes' => $itemData['notes'] ?? null,
                    'discount_type' => $itemData['discount_type'],
                    'discount' => $itemData['discount'] ?? 0,
                    'taxable' => isset($itemData['taxable']) ? true : false,
                    'inventory' => isset($itemData['inventory']) ? true : false,
                    'receiving_status' => $itemData['receiving_status'] ?? null,
                    'commodity_class' => $itemData['commodity_class'] ?? null,
                ]);

                $poItem->calculateTotal();
                $purchaseOrder->items()->save($poItem);
            }

            // Calculate totals
            $purchaseOrder->calculateTotals();

            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('purchase-orders', 'public');

                    PurchaseOrderAttachment::create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('companyadmin.purchase-orders.show', $purchaseOrder)
                ->with('toast_success', 'Purchase Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('toast_error', 'Error creating purchase order: ' . $e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('view', $purchaseOrder);

        $purchaseOrder->load(['vendor', 'warehouse', 'items.item', 'attachments']);

        return view('backend.companyadmin.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('update', $purchaseOrder);

        $companyId = auth()->user()->company_id;
        $vendors = Vendor::where('company_id', $companyId)->get();
        $items = Item::where('company_id', $companyId)->get();
        $warehouses = Warehouse::where('company_id', $companyId)->get();

        $purchaseOrder->load(['items']);

        return view('backend.companyadmin.purchase-orders.edit', compact('purchaseOrder', 'vendors', 'items', 'warehouses'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('update', $purchaseOrder);

        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'type' => 'required|in:draft,first_article,production',
            'order_date' => 'required|date',
            'expected_received_date' => 'nullable|date',
            'payment_terms' => 'nullable|string',
            'ship_to' => 'nullable|string',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'cage_number' => 'nullable|string',
            'discount_type' => 'required|in:flat,percentage',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $purchaseOrder->update($validated);

        return redirect()->route('companyadmin.purchase-orders.show', $purchaseOrder)
            ->with('toast_success', 'Purchase Order updated successfully!');
    }

    public function receive(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('update', $purchaseOrder);

        if ($purchaseOrder->status === 'received') {
            return back()->with('toast_error', 'Purchase Order already received!');
        }

        DB::beginTransaction();
        try {
            foreach ($purchaseOrder->items as $poItem) {
                if ($poItem->inventory) {
                    $item = $poItem->item;
                    $quantityBefore = $item->current_stock;

                    // Update item stock
                    $item->updateStock($poItem->quantity, 'add');

                    // Create inventory transaction
                    InventoryTransaction::create([
                        'company_id' => $purchaseOrder->company_id,
                        'item_id' => $item->id,
                        'warehouse_id' => $purchaseOrder->warehouse_id,
                        'type' => 'purchase',
                        'reference_type' => 'App\Models\PurchaseOrder',
                        'reference_id' => $purchaseOrder->id,
                        'quantity' => $poItem->quantity,
                        'quantity_before' => $quantityBefore,
                        'quantity_after' => $item->current_stock,
                        'unit_price' => $poItem->unit_price,
                        'notes' => 'Received from PO: ' . $purchaseOrder->po_number,
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            $purchaseOrder->update(['status' => 'received']);

            DB::commit();

            return redirect()->route('companyadmin.purchase-orders.show', $purchaseOrder)
                ->with('toast_success', 'Purchase Order received and inventory updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('toast_error', 'Error receiving purchase order: ' . $e->getMessage());
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('delete', $purchaseOrder);

        // Delete attachments
        foreach ($purchaseOrder->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }

        $purchaseOrder->delete();

        return redirect()->route('companyadmin.purchase-orders.index')
            ->with('toast_success', 'Purchase Order deleted successfully!');
    }
}
