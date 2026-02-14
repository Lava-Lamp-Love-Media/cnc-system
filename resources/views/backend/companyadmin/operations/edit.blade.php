@extends('layouts.app')

@section('title', 'Edit Operation')
@section('page-title', 'Edit Operation')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Operation: {{ $operation->name }}
        </h3>
    </div>

    <form method="POST" action="{{ route('company.operations.update', $operation->id) }}" id="operationForm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <!-- Left Column -->
                <div class="col-md-6">
                    <h5 class="text-warning">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Operation Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="operation_code"
                            class="form-control @error('operation_code') is-invalid @enderror"
                            value="{{ old('operation_code', $operation->operation_code) }}"
                            required>
                        @error('operation_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Operation Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $operation->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="4">{{ old('description', $operation->description) }}</textarea>
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
                            value="{{ old('hourly_rate', $operation->hourly_rate) }}">
                        @error('hourly_rate')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $operation->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $operation->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Operation
            </button>
            <a href="{{ route('company.operations.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.operations.show', $operation->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $('#operationForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
</script>
@endpush