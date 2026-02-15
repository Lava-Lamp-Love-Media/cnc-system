@extends('layouts.app')

@section('title', 'Edit Chamfer')
@section('page-title', 'Edit Chamfer Specification')

@section('content')

<form method="POST" action="{{ route('company.chamfers.update', $chamfer->id) }}" id="chamferForm">
    @csrf
    @method('PUT')

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Chamfer: {{ $chamfer->name }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Chamfer Code <span class="text-danger">*</span></label>
                        <input type="text" name="chamfer_code"
                            class="form-control @error('chamfer_code') is-invalid @enderror"
                            value="{{ old('chamfer_code', $chamfer->chamfer_code) }}" required>
                        @error('chamfer_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Chamfer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $chamfer->name) }}" required>
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
                            value="{{ old('size', $chamfer->size) }}" required>
                        @error('size')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Angle (degrees)</label>
                        <input type="number" step="0.01" name="angle"
                            class="form-control"
                            value="{{ old('angle', $chamfer->angle) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="unit_price"
                            class="form-control"
                            value="{{ old('unit_price', $chamfer->unit_price) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', $chamfer->sort_order) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $chamfer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $chamfer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $chamfer->description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Chamfer
            </button>
            <a href="{{ route('company.chamfers.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.chamfers.show', $chamfer->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#chamferForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
});
</script>
@endpush