@extends('layouts.app')

@section('title', 'Edit Debur')
@section('page-title', 'Edit Debur Specification')

@section('content')

<form method="POST" action="{{ route('company.deburs.update', $debur->id) }}" id="deburForm">
    @csrf
    @method('PUT')

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Debur: {{ $debur->name }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Debur Code <span class="text-danger">*</span></label>
                        <input type="text" name="debur_code"
                            class="form-control @error('debur_code') is-invalid @enderror"
                            value="{{ old('debur_code', $debur->debur_code) }}" required>
                        @error('debur_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Debur Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $debur->name) }}" required>
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
                            class="form-control"
                            value="{{ old('size', $debur->size) }}">
                        <small class="text-muted">Optional</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="unit_price"
                            class="form-control"
                            value="{{ old('unit_price', $debur->unit_price) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', $debur->sort_order) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $debur->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $debur->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $debur->description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Debur
            </button>
            <a href="{{ route('company.deburs.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.deburs.show', $debur->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#deburForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
});
</script>
@endpush