@extends('layouts.app')

@section('page-title', 'Inventory')

@section('content')
<div class="row">
    <!-- Low Stock Alert -->
    @if($lowStockItems->count() > 0)
    <div class="col-12">
        <div class="alert alert-warning">
            <h5><i class="fas fa-exclamation-triangle mr-2"></i> Low Stock Alert</h5>
            <p class="mb-0">You have <strong>{{ $lowStockItems->count() }}</strong> item(s) with low stock levels.</p>
        </div>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="col-md-3">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ $items->count() }}</h3>
                <p>Total Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ $items->sum('current_stock') }}</h3>
                <p>Total Stock</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>{{ $lowStockItems->count() }}</h3>
                <p>Low Stock Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>${{ number_format($items->sum(function($item) { return $item->current_stock * $item->cost_price; }), 2) }}</h3>
                <p>Total Value</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Inventory Items</h3>
                    <div>
                        <a href="{{ route('company.inventory.transactions') }}" class="btn btn-info">
                            <i class="fas fa-history mr-1"></i> View Transactions
                        </a>
                        <a href="{{ route('company.items.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Add Item
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Item</th>
                                <th>SKU</th>
                                <th>Class</th>
                                <th>Warehouse</th>
                                <th>Current Stock</th>
                                <th>Min Stock</th>
                                <th>Re-order Level</th>
                                <th>Unit</th>
                                <th>Cost Price</th>
                                <th>Stock Value</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr class="{{ $item->isLowStock() ? 'table-warning' : '' }}">
                                <td>
                                    <strong>{{ $item->name }}</strong>
                                    @if($item->isLowStock())
                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Low Stock</small>
                                    @endif
                                </td>
                                <td><span class="badge badge-secondary">{{ $item->sku }}</span></td>
                                <td>
                                    @switch($item->class)
                                        @case('tooling')
                                            <span class="badge badge-info">Tooling</span>
                                            @break
                                        @case('sellable')
                                            <span class="badge badge-success">Sellable</span>
                                            @break
                                        @case('raw_stock')
                                            <span class="badge badge-warning">Raw Stock</span>
                                            @break
                                        @case('consommable')
                                            <span class="badge badge-primary">Consommable</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $item->warehouse->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($item->isLowStock())
                                        <span class="badge badge-danger badge-lg">{{ $item->current_stock }}</span>
                                    @else
                                        <span class="badge badge-success badge-lg">{{ $item->current_stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->stock_min }}</td>
                                <td class="text-center">{{ $item->reorder_level }}</td>
                                <td>{{ ucfirst($item->unit) }}</td>
                                <td>${{ number_format($item->cost_price, 2) }}</td>
                                <td><strong>${{ number_format($item->current_stock * $item->cost_price, 2) }}</strong></td>
                                <td>
                                    @if($item->current_stock > $item->reorder_level)
                                        <span class="badge badge-success">Healthy</span>
                                    @elseif($item->current_stock > $item->stock_min)
                                        <span class="badge badge-warning">Low</span>
                                    @else
                                        <span class="badge badge-danger">Critical</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('company.items.show', $item) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                data-toggle="modal" 
                                                data-target="#adjustModal{{ $item->id }}"
                                                title="Adjust">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>

                                    <!-- Adjust Modal -->
                                    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('company.inventory.adjust', $item) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Adjust Inventory: {{ $item->name }}</h5>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-warehouse fa-4x text-muted mb-3"></i>
                    <h4>No Inventory Items Found</h4>
                    <p class="text-muted">Start by creating items with inventory tracking enabled.</p>
                    <a href="{{ route('company.items.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Create Item
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection