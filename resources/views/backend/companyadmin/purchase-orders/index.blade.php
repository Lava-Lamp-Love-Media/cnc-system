@extends('layouts.app')

@section('page-title', 'Purchase Orders')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">All Purchase Orders</h3>
                    <a href="{{ route('company.purchase-orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Create Purchase Order
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if($purchaseOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>PO Number</th>
                                <th>Vendor</th>
                                <th>Type</th>
                                <th>Order Date</th>
                                <th>Expected Date</th>
                                <th>Items</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrders as $po)
                            <tr>
                                <td>
                                    <a href="{{ route('company.purchase-orders.show', $po) }}" class="font-weight-bold">
                                        {{ $po->po_number }}
                                    </a>
                                </td>
                                <td>{{ $po->vendor->name }}</td>
                                <td>
                                    @switch($po->type)
                                        @case('draft')
                                            <span class="badge badge-secondary">Draft</span>
                                            @break
                                        @case('first_article')
                                            <span class="badge badge-info">First Article</span>
                                            @break
                                        @case('production')
                                            <span class="badge badge-primary">Production</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $po->order_date->format('M d, Y') }}</td>
                                <td>
                                    @if($po->expected_received_date)
                                        {{ $po->expected_received_date->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $po->items->count() }} items</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($po->grand_total, 2) }}</strong>
                                </td>
                                <td>
                                    @switch($po->status)
                                        @case('draft')
                                            <span class="badge badge-secondary">Draft</span>
                                            @break
                                        @case('pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="badge badge-info">Approved</span>
                                            @break
                                        @case('received')
                                            <span class="badge badge-success">Received</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('company.purchase-orders.show', $po) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($po->status !== 'received')
                                        <a href="{{ route('company.purchase-orders.edit', $po) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('company.purchase-orders.receive', $po) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    title="Mark as Received"
                                                    onclick="return confirm('Mark this PO as received and update inventory?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($po->status !== 'received')
                                        <form action="{{ route('company.purchase-orders.destroy', $po) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $purchaseOrders->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>No Purchase Orders Found</h4>
                    <p class="text-muted">Create your first purchase order to get started.</p>
                    <a href="{{ route('company.purchase-orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Create Purchase Order
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection