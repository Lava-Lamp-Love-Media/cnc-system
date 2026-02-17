@extends('layouts.app')

@section('page-title', 'Edit Purchase Order')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('company.purchase-orders.update', $purchaseOrder) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Edit Purchase Order: {{ $purchaseOrder->po_number }}</h3>
                        <a href="{{ route('company.purchase-orders.show', $purchaseOrder) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Vendor & Basic Info -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_id">Vendor <span class="text-danger">*</span></label>
                                <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror" required>
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" 
                                                {{ old('vendor_id', $purchaseOrder->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Purchase Order Number</label>
                                <input type="text" class="form-control" value="{{ $purchaseOrder->po_number }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Type <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_draft" name="type" value="draft" 
                                                   class="custom-control-input" 
                                                   {{ old('type', $purchaseOrder->type) == 'draft' ? 'checked' : '' }} required>
                                            <label class="custom-control-label" for="type_draft">Draft</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_first_article" name="type" value="first_article" 
                                                   class="custom-control-input" 
                                                   {{ old('type', $purchaseOrder->type) == 'first_article' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_first_article">First Article</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_production" name="type" value="production" 
                                                   class="custom-control-input" 
                                                   {{ old('type', $purchaseOrder->type) == 'production' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_production">Production</label>
                                        </div>
                                    </div>
                                </div>
                                @error('type')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="order_date">Order Date <span class="text-danger">*</span></label>
                                <input type="date" name="order_date" id="order_date" 
                                       class="form-control @error('order_date') is-invalid @enderror" 
                                       value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}" required>
                                @error('order_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="expected_received_date">Expected Received Date</label>
                                <input type="date" name="expected_received_date" id="expected_received_date" 
                                       class="form-control @error('expected_received_date') is-invalid @enderror" 
                                       value="{{ old('expected_received_date', $purchaseOrder->expected_received_date?->format('Y-m-d')) }}">
                                @error('expected_received_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment_terms">Payment Terms</label>
                                <select name="payment_terms" id="payment_terms" class="form-control @error('payment_terms') is-invalid @enderror">
                                    <option value="">Select Payment Terms</option>
                                    <option value="net_15" {{ old('payment_terms', $purchaseOrder->payment_terms) == 'net_15' ? 'selected' : '' }}>Net 15</option>
                                    <option value="net_30" {{ old('payment_terms', $purchaseOrder->payment_terms) == 'net_30' ? 'selected' : '' }}>Net 30</option>
                                    <option value="net_45" {{ old('payment_terms', $purchaseOrder->payment_terms) == 'net_45' ? 'selected' : '' }}>Net 45</option>
                                    <option value="net_60" {{ old('payment_terms', $purchaseOrder->payment_terms) == 'net_60' ? 'selected' : '' }}>Net 60</option>
                                    <option value="due_on_receipt" {{ old('payment_terms', $purchaseOrder->payment_terms) == 'due_on_receipt' ? 'selected' : '' }}>Due on Receipt</option>
                                </select>
                                @error('payment_terms')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cage_number">Cage Number</label>
                                <input type="text" name="cage_number" id="cage_number" 
                                       class="form-control @error('cage_number') is-invalid @enderror" 
                                       value="{{ old('cage_number', $purchaseOrder->cage_number) }}">
                                @error('cage_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ship_to">Ship To</label>
                                <textarea name="ship_to" id="ship_to" rows="3" 
                                          class="form-control @error('ship_to') is-invalid @enderror" 
                                          placeholder="Shipping address...">{{ old('ship_to', $purchaseOrder->ship_to) }}</textarea>
                                @error('ship_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="warehouse_id">Warehouse</label>
                                <select name="warehouse_id" id="warehouse_id" class="form-control @error('warehouse_id') is-invalid @enderror">
                                    <option value="">Select Warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" 
                                                {{ old('warehouse_id', $purchaseOrder->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Discount & Tax -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select name="discount_type" id="discount_type" class="form-control">
                                    <option value="flat" {{ old('discount_type', $purchaseOrder->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                    <option value="percentage" {{ old('discount_type', $purchaseOrder->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" name="discount" id="discount" step="0.01" 
                                       class="form-control" value="{{ old('discount', $purchaseOrder->discount) }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">Tax (%)</label>
                                <input type="number" name="tax" id="tax" step="0.01" 
                                       class="form-control" value="{{ old('tax', $purchaseOrder->tax) }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Grand Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control" readonly value="{{ number_format($purchaseOrder->grand_total, 2) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Description & Notes -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                          class="form-control" placeholder="Purchase order description...">{{ old('description', $purchaseOrder->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea name="additional_notes" id="additional_notes" rows="3" 
                                          class="form-control" placeholder="Any additional notes...">{{ old('additional_notes', $purchaseOrder->additional_notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('company.purchase-orders.show', $purchaseOrder) }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Purchase Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection