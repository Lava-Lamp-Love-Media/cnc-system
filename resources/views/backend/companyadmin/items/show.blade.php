@extends('layouts.app')

@section('page-title', 'Item Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Item Image & Basic Info -->
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" 
                     class="img-fluid rounded mb-3" style="max-height: 300px;">
                
                <h4>{{ $item->name }}</h4>
                <p class="text-muted">{{ $item->description }}</p>
                
                <div class="mt-3">
                    @switch($item->class)
                        @case('tooling')
                            <span class="badge badge-info badge-lg">Tooling</span>
                            @break
                        @case('sellable')
                            <span class="badge badge-success badge-lg">Sellable</span>
                            @break
                        @case('raw_stock')
                            <span class="badge badge-warning badge-lg">Raw Stock</span>
                            @break
                        @case('consommable')
                            <span class="badge badge-primary badge-lg">Consommable</span>
                            @break
                    @endswitch
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('company.items.edit', $item) }}" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-edit mr-1"></i> Edit Item
                </a>
                
                @if($item->is_inventory)
                <button type="button" class="btn btn-info btn-block mb-2" data-toggle="modal" data-target="#adjustInventoryModal">
                    <i class="fas fa-exchange-alt mr-1"></i> Adjust Inventory
                </button>
                @endif

                <form action="{{ route('company.items.destroy', $item) }}" method="POST" class="d-inline w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block btn-delete">
                        <i class="fas fa-trash mr-1"></i> Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Item Details -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Item Details</h5>
                    <a href="{{ route('company.items.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">SKU:</th>
                                <td><span class="badge badge-secondary">{{ $item->sku }}</span></td>
                            </tr>
                            <tr>
                                <th>Unit:</th>
                                <td>{{ ucfirst($item->unit) }}</td>
                            </tr>
                            <tr>
                                <th>Cost Price:</th>
                                <td><strong>${{ number_format($item->cost_price, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Sell Price:</th>
                                <td><strong>${{ number_format($item->sell_price, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Taxable:</th>
                                <td>
                                    @if($item->is_taxable)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Current Stock:</th>
                                <td>
                                    @if($item->isLowStock())
                                        <span class="badge badge-danger badge-lg">{{ $item->current_stock }}</span>
                                        <small class="text-danger d-block">Low Stock!</small>
                                    @else
                                        <span class="badge badge-success badge-lg">{{ $item->current_stock }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Minimum Stock:</th>
                                <td>{{ $item->stock_min }}</td>
                            </tr>
                            <tr>
                                <th>Re-order Level:</th>
                                <td>{{ $item->reorder_level }}</td>
                            </tr>
                            <tr>
                                <th>Warehouse:</th>
                                <td>{{ $item->warehouse->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Inventory Tracking:</th>
                                <td>
                                    @if($item->is_inventory)
                                        <span class="badge badge-success">Enabled</span>
                                    @else
                                        <span class="badge badge-secondary">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($item->notes)
                <div class="mt-3">
                    <h6>Notes:</h6>
                    <p class="text-muted">{{ $item->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Inventory Transactions -->
        @if($item->is_inventory && $item->inventoryTransactions->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Inventory Transactions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Before</th>
                                <th>After</th>
                                <th>Notes</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->inventoryTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @switch($transaction->type)
                                        @case('purchase')
                                            <span class="badge badge-success">Purchase</span>
                                            @break
                                        @case('sale')
                                            <span class="badge badge-info">Sale</span>
                                            @break
                                        @case('adjustment')
                                            <span class="badge badge-warning">Adjustment</span>
                                            @break
                                        @case('transfer')
                                            <span class="badge badge-primary">Transfer</span>
                                            @break
                                        @case('return')
                                            <span class="badge badge-secondary">Return</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($transaction->quantity > 0)
                                        <span class="text-success">+{{ $transaction->quantity }}</span>
                                    @else
                                        <span class="text-danger">{{ $transaction->quantity }}</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->quantity_before }}</td>
                                <td>{{ $transaction->quantity_after }}</td>
                                <td>{{ $transaction->notes ?? '-' }}</td>
                                <td>{{ $transaction->createdBy->name ?? 'System' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Adjust Inventory Modal -->
@if($item->is_inventory)
<div class="modal fade" id="adjustInventoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('company.inventory.adjust', $item) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adjust Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Current Stock:</strong> {{ $item->current_stock }} {{ $item->unit }}
                    </div>

                    <div class="form-group">
                        <label>Adjustment Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required>
                            <option value="add">Add Stock</option>
                            <option value="subtract">Subtract Stock</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Reason for adjustment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Adjust Inventory</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection