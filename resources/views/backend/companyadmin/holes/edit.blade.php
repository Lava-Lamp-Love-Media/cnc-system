@extends('layouts.app')

@section('title', 'Create Hole')
@section('page-title', 'Add New Hole Specification')

@section('content')

<form method="POST" action="{{ route('company.holes.store') }}" id="holeForm">
    @csrf

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-circle"></i> Hole Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hole Code <span class="text-danger">*</span></label>
                        <input type="text" name="hole_code"
                            class="form-control @error('hole_code') is-invalid @enderror"
                            value="{{ old('hole_code') }}"
                            placeholder="e.g., HOLE-8.5-THRU" required>
                        @error('hole_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Unique identifier for this hole specification</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hole Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., Ø8.5mm Through Hole" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hole Size (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="size"
                            class="form-control @error('size') is-invalid @enderror"
                            value="{{ old('size') }}"
                            placeholder="e.g., 8.500" required>
                        @error('size')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Diameter in millimeters</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hole Type <span class="text-danger">*</span></label>
                        <select name="hole_type" class="form-control @error('hole_type') is-invalid @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="through" {{ old('hole_type') == 'through' ? 'selected' : '' }}>Through Hole</option>
                            <option value="blind" {{ old('hole_type') == 'blind' ? 'selected' : '' }}>Blind Hole</option>
                            <option value="countersink" {{ old('hole_type') == 'countersink' ? 'selected' : '' }}>Countersink</option>
                            <option value="counterbore" {{ old('hole_type') == 'counterbore' ? 'selected' : '' }}>Counterbore</option>
                        </select>
                        @error('hole_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="unit_price"
                            class="form-control @error('unit_price') is-invalid @enderror"
                            value="{{ old('unit_price', '0.00') }}"
                            placeholder="e.g., 5.00" required>
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
                        <small class="text-muted">Display order in dropdowns (lower numbers appear first)</small>
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
                    placeholder="Optional description of this hole specification">{{ old('description') }}</textarea>
                <small class="text-muted">e.g., "Clearance hole for M10 bolt" or "Pilot hole for M8 tap"</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Hole
            </button>
            <a href="{{ route('company.holes.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#holeForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush