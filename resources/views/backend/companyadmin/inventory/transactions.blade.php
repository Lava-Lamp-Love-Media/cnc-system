@extends('layouts.app')

@section('page-title', 'Inventory Transactions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Inventory Transactions</h3>
                    <a href="{{ route('company.inventory.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Inventory
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Date & Time</th>
                                <th>Item</th>
                                <th>SKU</th>
                                <th>Type</th>
                                <th>Warehouse</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Before</th>
                                <th class="text-center">After</th>
                                <th>Unit Price</th>
                                <th>Reference</th>
                                <th>Notes</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    <small>{{ $transaction->created_at->format('M d, Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $transaction->created_at->format('H:i A') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $transaction->item->name }}</strong>
                                </td>
                                <td><span class="badge badge-secondary">{{ $transaction->item->sku }}</span></td>
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
                                <td>{{ $transaction->warehouse->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($transaction->quantity > 0)
                                        <span class="text-success font-weight-bold">+{{ $transaction->quantity }}</span>
                                    @else
                                        <span class="text-danger font-weight-bold">{{ $transaction->quantity }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $transaction->quantity_before }}</td>
                                <td class="text-center"><strong>{{ $transaction->quantity_after }}</strong></td>
                                <td>${{ number_format($transaction->unit_price, 2) }}</td>
                                <td>
                                    @if($transaction->reference_type && $transaction->reference_id)
                                        <small class="text-muted">
                                            {{ class_basename($transaction->reference_type) }} #{{ $transaction->reference_id }}
                                        </small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->notes)
                                        <small>{{ Str::limit($transaction->notes, 30) }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->createdBy->name ?? 'System' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                    <h4>No Transactions Found</h4>
                    <p class="text-muted">Inventory transactions will appear here.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection