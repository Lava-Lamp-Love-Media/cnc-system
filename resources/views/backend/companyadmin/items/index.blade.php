@extends('layouts.app')

@section('page-title', 'Items')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">All Items</h3>
                    <div>
                        <a href="{{ route('company.items.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Create Item
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
                                <th width="80">Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Class</th>
                                <th>Current Stock</th>
                                <th>Unit</th>
                                <th>Cost Price</th>
                                <th>Sell Price</th>
                                <th>Warehouse</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                         class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $item->name }}</strong>
                                    @if($item->description)
                                        <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
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
                                <td>
                                    @if($item->isLowStock())
                                        <span class="badge badge-danger">{{ $item->current_stock }}</span>
                                        <small class="text-danger d-block">Low Stock!</small>
                                    @else
                                        <span class="badge badge-success">{{ $item->current_stock }}</span>
                                    @endif
                                </td>
                                <td>{{ ucfirst($item->unit) }}</td>
                                <td>${{ number_format($item->cost_price, 2) }}</td>
                                <td>${{ number_format($item->sell_price, 2) }}</td>
                                <td>{{ $item->warehouse->name ?? 'N/A' }}</td>
                                <td>
                                    @switch($item->status)
                                        @case('active')
                                            <span class="badge badge-success">Active</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge badge-secondary">Inactive</span>
                                            @break
                                        @case('discontinued')
                                            <span class="badge badge-danger">Discontinued</span>
                                            @break
                                        @default
                                            <span class="badge badge-light">{{ ucfirst($item->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('company.items.show', $item) }}"
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('company.items.edit', $item) }}"
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('company.items.destroy', $item) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $items->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-box fa-4x text-muted mb-3"></i>
                    <h4>No Items Found</h4>
                    <p class="text-muted">Create your first item to get started.</p>
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