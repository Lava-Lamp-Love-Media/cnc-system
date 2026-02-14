@extends('layouts.app')

@section('title', 'Create Operation')
@section('page-title', 'Add New Operation')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Create New Operation Type
        </h3>
    </div>

    <form method="POST" action="{{ route('company.operations.store') }}" id="operationForm">
        @csrf

        <div class="card-body">
            <div class="row">

                <!-- Left Column -->
                <div class="col-md-6">
                    <h5 class="text-primary">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Operation Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="operation_code"
                            id="operationCode"
                            class="form-control @error('operation_code') is-invalid @enderror"
                            value="{{ old('operation_code') }}"
                            placeholder="e.g., OPT-001"
                            required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Unique identifier for this operation
                        </small>
                        @error('operation_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Operation Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., CNC Milling, Turning, Drilling"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Detailed description of this operation...">{{ old('description') }}</textarea>
                    </div>

                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <h5 class="text-success">
                        <i class="fas fa-dollar-sign"></i> Pricing & Status
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Hourly Rate ($)</label>
                        <input type="number"
                            step="0.01"
                            name="hourly_rate"
                            class="form-control @error('hourly_rate') is-invalid @enderror"
                            value="{{ old('hourly_rate') }}"
                            placeholder="0.00">
                        <small class="text-muted">Cost per hour for this operation</small>
                        @error('hourly_rate')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Examples:</strong>
                        <ul class="mb-0 mt-2 pl-3">
                            <li>CNC Milling</li>
                            <li>CNC Turning</li>
                            <li>Drilling</li>
                            <li>Grinding</li>
                            <li>EDM Cutting</li>
                            <li>Welding</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required.
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Operation
            </button>
            <a href="{{ route('company.operations.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-generate operation code suggestion
        $('input[name="name"]').on('blur', function() {
            var name = $(this).val();
            if (name && !$('#operationCode').val()) {
                var code = name.toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .substring(0, 3) + '-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                $('#operationCode').val(code);
            }
        });

        // Form submission
        $('#operationForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });
    });
</script>
@endpush