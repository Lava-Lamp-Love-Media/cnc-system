@extends('layouts.app')

@section('title', 'Create Chamfer')
@section('page-title', 'Add New Chamfer Specification')

@section('content')

<form method="POST" action="{{ route('company.chamfers.store') }}" id="chamferForm">
    @csrf

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-draw-polygon"></i> Chamfer Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Chamfer Code <span class="text-danger">*</span></label>
                        <input type="text" name="chamfer_code"
                            class="form-control @error('chamfer_code') is-invalid @enderror"
                            value="{{ old('chamfer_code') }}"
                            placeholder="e.g., CHMF-0.5-45" required>
                        @error('chamfer_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Unique identifier for this chamfer</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Chamfer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., 0.5mm × 45°" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Chamfer Size (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="size"
                            class="form-control @error('size') is-invalid @enderror"
                            value="{{ old('size') }}"
                            placeholder="e.g., 0.500" required>
                        @error('size')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Width in millimeters</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Angle (degrees)</label>
                        <input type="number" step="0.01" name="angle"
                            class="form-control @error('angle') is-invalid @enderror"
                            value="{{ old('angle') }}"
                            placeholder="e.g., 45.00">
                        @error('angle')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Optional (e.g., 30°, 45°, 60°)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="unit_price"
                            class="form-control @error('unit_price') is-invalid @enderror"
                            value="{{ old('unit_price', '0.00') }}"
                            placeholder="e.g., 2.00" required>
                        @error('unit_price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}"
                            placeholder="0">
                        <small class="text-muted">Display order in dropdowns</small>
                    </div>
                </div>
                <div class="col-md-6">
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
                    placeholder="Optional description">{{ old('description') }}</textarea>
                <small class="text-muted">e.g., "Standard chamfer for edge breaking"</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Chamfer
            </button>
            <a href="{{ route('company.chamfers.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#chamferForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush