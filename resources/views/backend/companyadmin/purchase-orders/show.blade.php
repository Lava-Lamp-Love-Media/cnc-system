@extends('layouts.app')

@section('page-title', 'Purchase Order Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Purchase Order: {{ $purchaseOrder->po_number }}</h3>
                    <div>
                        @if($purchaseOrder->status !== 'received')
                        <a href="{{ route('company.purchase-orders.edit', $purchaseOrder) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        
                        <form action="{{ route('company.purchase-orders.receive', $purchaseOrder) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Mark this PO as received and update inventory?')">
                                <i class="fas fa-check mr-1"></i> Mark as Received
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('company.purchase-orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    @switch($purchaseOrder->status)
                        @case('draft')
                            <span class="badge badge-secondary badge-lg">Draft</span>
                            @break
                        @case('pending')
                            <span class="badge badge-warning badge-lg">Pending</span>
                            @break
                        @case('approved')
                            <span class="badge badge-info badge-lg">Approved</span>
                            @break
                        @case('received')
                            <span class="badge badge-success badge-lg">Received</span>
                            @break
                        @case('cancelled')
                            <span class="badge badge-danger badge-lg">Cancelled</span>
                            @break
                    @endswitch

                    @switch($purchaseOrder->type)
                        @case('draft')
                            <span class="badge badge-secondary badge-lg ml-2">Draft Order</span>
                            @break
                        @case('first_article')
                            <span class="badge badge-info badge-lg ml-2">First Article</span>
                            @break
                        @case('production')
                            <span class="badge badge-primary badge-lg ml-2">Production</span>
                            @break
                    @endswitch
                </div>

                <!-- PO Details -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Vendor Information</h5>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Vendor:</th>
                                <td><strong>{{ $purchaseOrder->vendor->name }}</strong></td>
                            </tr>
                            @if($purchaseOrder->vendor->email)
                            <tr>
                                <th>Email:</th>
                                <td>{{ $purchaseOrder->vendor->email }}</td>
                            </tr>
                            @endif
                            @if($purchaseOrder->vendor->phone)
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $purchaseOrder->vendor->phone }}</td>
                            </tr>
                            @endif
                            @if($purchaseOrder->payment_terms)
                            <tr>
                                <th>Payment Terms:</th>
                                <td>{{ ucwords(str_replace('_', ' ', $purchaseOrder->payment_terms)) }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Order Information</h5>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">PO Number:</th>
                                <td><strong>{{ $purchaseOrder->po_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Order Date:</th>
                                <td>{{ $purchaseOrder->order_date->format('M d, Y') }}</td>
                            </tr>
                            @if($purchaseOrder->expected_received_date)
                            <tr>
                                <th>Expected Date:</th>
                                <td>{{ $purchaseOrder->expected_received_date->format('M d, Y') }}</td>
                            </tr>
                            @endif
                            @if($purchaseOrder->warehouse)
                            <tr>
                                <th>Warehouse:</th>
                                <td>{{ $purchaseOrder->warehouse->name }}</td>
                            </tr>
                            @endif
                            @if($purchaseOrder->cage_number)
                            <tr>
                                <th>Cage Number:</th>
                                <td>{{ $purchaseOrder->cage_number }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($purchaseOrder->ship_to)
                <div class="row mt-3">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3">Shipping Address</h5>
                        <p class="text-muted">{{ $purchaseOrder->ship_to }}</p>
                    </div>
                </div>
                @endif

                <!-- Items Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3">Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>SKU</th>
                                        <th>Unit</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-center">Inventory</th>
                                        <th class="text-center">Taxable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchaseOrder->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->item->name }}</strong>
                                            @if($item->notes)
                                            <br><small class="text-muted">{{ $item->notes }}</small>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-secondary">{{ $item->item_sku }}</span></td>
                                        <td>{{ ucfirst($item->unit) }}</td>
                                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">
                                            @if($item->discount > 0)
                                                @if($item->discount_type === 'percentage')
                                                    {{ $item->discount }}%
                                                @else
                                                    ${{ number_format($item->discount, 2) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right"><strong>${{ number_format($item->total, 2) }}</strong></td>
                                        <td class="text-center">
                                            @if($item->inventory)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->taxable)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th>Subtotal:</th>
                                <td class="text-right">${{ number_format($purchaseOrder->subtotal, 2) }}</td>
                            </tr>
                            @if($purchaseOrder->discount > 0)
                            <tr>
                                <th>Discount
                                    @if($purchaseOrder->discount_type === 'percentage')
                                        ({{ $purchaseOrder->discount }}%)
                                    @endif
                                    :
                                </th>
                                <td class="text-right text-danger">
                                    -${{ number_format($purchaseOrder->discount_type === 'percentage' 
                                        ? ($purchaseOrder->subtotal * $purchaseOrder->discount / 100) 
                                        : $purchaseOrder->discount, 2) }}
                                </td>
                            </tr>
                            @endif
                            @if($purchaseOrder->tax > 0)
                            <tr>
                                <th>Tax ({{ $purchaseOrder->tax }}%):</th>
                                <td class="text-right">
                                    ${{ number_format(($purchaseOrder->subtotal - 
                                        ($purchaseOrder->discount_type === 'percentage' 
                                            ? ($purchaseOrder->subtotal * $purchaseOrder->discount / 100) 
                                            : $purchaseOrder->discount)) * $purchaseOrder->tax / 100, 2) }}
                                </td>
                            </tr>
                            @endif
                            <tr class="table-active">
                                <th><h5>Grand Total:</h5></th>
                                <td class="text-right"><h5>${{ number_format($purchaseOrder->grand_total, 2) }}</h5></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Description & Notes -->
                @if($purchaseOrder->description || $purchaseOrder->additional_notes)
                <div class="row mt-4">
                    @if($purchaseOrder->description)
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Description</h5>
                        <p class="text-muted">{{ $purchaseOrder->description }}</p>
                    </div>
                    @endif

                    @if($purchaseOrder->additional_notes)
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Additional Notes</h5>
                        <p class="text-muted">{{ $purchaseOrder->additional_notes }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Attachments -->
                @if($purchaseOrder->attachments->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3">Attachments</h5>
                        <div class="row">
                            @foreach($purchaseOrder->attachments as $attachment)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        @if(in_array($attachment->file_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']))
                                            <img src="{{ $attachment->file_url }}" class="img-fluid mb-2" alt="{{ $attachment->file_name }}">
                                        @else
                                            <i class="fas fa-file fa-3x mb-2 text-muted"></i>
                                        @endif
                                        <p class="mb-1"><small>{{ $attachment->file_name }}</small></p>
                                        <a href="{{ $attachment->file_url }}" class="btn btn-sm btn-primary" download>
                                            <i class="fas fa-download mr-1"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3">Timeline</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-circle text-primary mr-2"></i>
                                <strong>Created:</strong> {{ $purchaseOrder->created_at->format('M d, Y H:i A') }}
                            </li>
                            @if($purchaseOrder->updated_at != $purchaseOrder->created_at)
                            <li class="mb-2">
                                <i class="fas fa-circle text-info mr-2"></i>
                                <strong>Last Updated:</strong> {{ $purchaseOrder->updated_at->format('M d, Y H:i A') }}
                            </li>
                            @endif
                            @if($purchaseOrder->status === 'received')
                            <li class="mb-2">
                                <i class="fas fa-circle text-success mr-2"></i>
                                <strong>Received:</strong> {{ $purchaseOrder->updated_at->format('M d, Y H:i A') }}
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection