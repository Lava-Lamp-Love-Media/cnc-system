@extends('layouts.app')

@section('title', 'Create Debur')
@section('page-title', 'Add New Debur Specification')

@section('content')

<form method="POST" action="{{ route('company.deburs.store') }}" id="deburForm">
    @csrf

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cut"></i> Debur Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Debur Code <span class="text-danger">*</span></label>
                        <input type="text" name="debur_code"
                            class="form-control @error('debur_code') is-invalid @enderror"
                            value="{{ old('debur_code') }}"
                            placeholder="e.g., DBR-STANDARD" required>
                        @error('debur_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Unique identifier for this debur</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Debur Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., Standard Debur" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Debur Size (mm)</label>
                        <input type="number" step="0.001" name="size"
                            class="form-control @error('size') is-invalid @enderror"
                            value="{{ old('size') }}"
                            placeholder="e.g., 0.200">
                        @error('size')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Optional - amount of material removed</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="unit_price"
                            class="form-control @error('unit_price') is-invalid @enderror"
                            value="{{ old('unit_price', '0.00') }}"
                            placeholder="e.g., 0.75" required>
                        @error('unit_price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}"
                            placeholder="0">
                        <small class="text-muted">Display order in dropdowns</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Optional description of this debur specification">{{ old('description') }}</textarea>
                <small class="text-muted">e.g., "Light edge break for precision parts"</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Debur
            </button>
            <a href="{{ route('company.deburs.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#deburForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush