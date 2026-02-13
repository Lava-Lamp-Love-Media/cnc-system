@extends('layouts.app')

@section('title', 'Create Machine')
@section('page-title', 'Add New Machine')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Register New Machine
        </h3>
    </div>

    <form method="POST" action="{{ route('company.machines.store') }}" enctype="multipart/form-data" id="machineForm">
        @csrf

        <div class="card-body">
            <div class="row">

                <!-- Left Column: Basic Information -->
                <div class="col-md-6">
                    <h5 class="text-primary">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Machine Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., CNC Milling Machine"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Machine Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="machine_code"
                            id="machineCode"
                            class="form-control @error('machine_code') is-invalid @enderror"
                            value="{{ old('machine_code') }}"
                            placeholder="e.g., CNC-001"
                            required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Unique identifier for this machine
                        </small>
                        @error('machine_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Manufacturer</label>
                        <input type="text"
                            name="manufacturer"
                            class="form-control"
                            value="{{ old('manufacturer') }}"
                            placeholder="e.g., Haas, DMG MORI, Mazak">
                    </div>

                    <div class="form-group">
                        <label>Model</label>
                        <input type="text"
                            name="model"
                            class="form-control"
                            value="{{ old('model') }}"
                            placeholder="e.g., VF-2">
                    </div>

                    <div class="form-group">
                        <label>Serial Number</label>
                        <input type="text"
                            name="serial_number"
                            class="form-control"
                            value="{{ old('serial_number') }}"
                            placeholder="e.g., SN-123456">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year of Manufacture</label>
                                <input type="number"
                                    name="year_of_manufacture"
                                    class="form-control"
                                    value="{{ old('year_of_manufacture') }}"
                                    min="1900"
                                    max="{{ date('Y') + 1 }}"
                                    placeholder="{{ date('Y') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input type="date"
                                    name="purchase_date"
                                    class="form-control"
                                    value="{{ old('purchase_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Purchase Price ($)</label>
                        <input type="number"
                            step="0.01"
                            name="purchase_price"
                            class="form-control"
                            value="{{ old('purchase_price') }}"
                            placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label>Machine Image</label>
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input"
                                id="machineImage"
                                name="image"
                                accept="image/*">
                            <label class="custom-file-label" for="machineImage">Choose file</label>
                        </div>
                        <small class="text-muted">Max size: 2MB (jpeg, png, jpg, gif)</small>
                    </div>

                </div>

                <!-- Right Column: Operational Details -->
                <div class="col-md-6">
                    <h5 class="text-success">
                        <i class="fas fa-cogs"></i> Operational Details
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Under Maintenance
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                            <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>
                                Broken
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text"
                            name="location"
                            class="form-control"
                            value="{{ old('location') }}"
                            placeholder="e.g., Shop Floor A, Zone 1">
                    </div>

                    <div class="form-group">
                        <label>Operating Hours</label>
                        <input type="number"
                            name="operating_hours"
                            class="form-control"
                            value="{{ old('operating_hours', 0) }}"
                            min="0"
                            placeholder="Total operating hours">
                    </div>

                    <div class="form-group">
                        <label>Last Maintenance Date</label>
                        <input type="date"
                            name="last_maintenance_date"
                            class="form-control"
                            value="{{ old('last_maintenance_date') }}">
                    </div>

                    <div class="form-group">
                        <label>Next Maintenance Date</label>
                        <input type="date"
                            name="next_maintenance_date"
                            class="form-control"
                            value="{{ old('next_maintenance_date') }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Additional information about this machine">{{ old('description') }}</textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Fields marked with <span class="text-danger">*</span> are required.
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Register Machine
            </button>
            <a href="{{ route('company.machines.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Custom file input label
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Auto-generate machine code suggestion
        $('input[name="name"]').on('blur', function() {
            var name = $(this).val();
            if (name && !$('#machineCode').val()) {
                var code = name.toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .substring(0, 3) + '-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                $('#machineCode').val(code);
            }
        });

        // Form submission
        $('#machineForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });
    });
</script>
@endpush