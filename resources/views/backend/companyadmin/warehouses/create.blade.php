@extends('layouts.app')

@section('title', 'Create Warehouse')
@section('page-title', 'Add New Warehouse')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Register New Warehouse
        </h3>
    </div>

    <form method="POST" action="{{ route('company.warehouses.store') }}" id="warehouseForm">
        @csrf

        <div class="card-body">
            <div class="row">

                <!-- Left Column: Basic Info -->
                <div class="col-md-6">
                    <h5 class="text-primary">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Warehouse Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="warehouse_code"
                            id="warehouseCode"
                            class="form-control @error('warehouse_code') is-invalid @enderror"
                            value="{{ old('warehouse_code') }}"
                            placeholder="e.g., WH-001"
                            required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Unique identifier for this warehouse
                        </small>
                        @error('warehouse_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Warehouse Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Main Warehouse"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Warehouse Type <span class="text-danger">*</span></label>
                        <select name="warehouse_type" class="form-control" required>
                            <option value="main" {{ old('warehouse_type', 'main') == 'main' ? 'selected' : '' }}>
                                Main Warehouse
                            </option>
                            <option value="secondary" {{ old('warehouse_type') == 'secondary' ? 'selected' : '' }}>
                                Secondary Warehouse
                            </option>
                            <option value="raw_material" {{ old('warehouse_type') == 'raw_material' ? 'selected' : '' }}>
                                Raw Material Storage
                            </option>
                            <option value="finished_goods" {{ old('warehouse_type') == 'finished_goods' ? 'selected' : '' }}>
                                Finished Goods Storage
                            </option>
                            <option value="tools" {{ old('warehouse_type') == 'tools' ? 'selected' : '' }}>
                                Tools & Equipment
                            </option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Storage Capacity</label>
                                <input type="number"
                                    step="0.01"
                                    name="storage_capacity"
                                    class="form-control"
                                    value="{{ old('storage_capacity') }}"
                                    placeholder="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Unit <span class="text-danger">*</span></label>
                                <select name="capacity_unit" class="form-control" required>
                                    <option value="sqm" {{ old('capacity_unit', 'sqm') == 'sqm' ? 'selected' : '' }}>SQM</option>
                                    <option value="cbm" {{ old('capacity_unit') == 'cbm' ? 'selected' : '' }}>CBM</option>
                                </select>
                            </div>
                        </div>
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
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Under Maintenance
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Additional warehouse information...">{{ old('description') }}</textarea>
                    </div>

                </div>

                <!-- Right Column: Contact & Address -->
                <div class="col-md-6">
                    <h5 class="text-success">
                        <i class="fas fa-map-marker-alt"></i> Contact & Location
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Manager Name</label>
                        <input type="text"
                            name="manager_name"
                            class="form-control"
                            value="{{ old('manager_name') }}"
                            placeholder="Warehouse manager name">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone') }}"
                            placeholder="+1 234 567 8900">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="warehouse@example.com">
                    </div>

                    <div class="form-group">
                        <label>Street Address</label>
                        <input type="text"
                            name="address"
                            class="form-control"
                            value="{{ old('address') }}"
                            placeholder="123 Industrial Blvd">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text"
                                    name="city"
                                    class="form-control"
                                    value="{{ old('city') }}"
                                    placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text"
                                    name="state"
                                    class="form-control"
                                    value="{{ old('state') }}"
                                    placeholder="State">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text"
                                    name="zip_code"
                                    class="form-control"
                                    value="{{ old('zip_code') }}"
                                    placeholder="12345">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text"
                                    name="country"
                                    class="form-control"
                                    value="{{ old('country', 'USA') }}"
                                    placeholder="USA">
                            </div>
                        </div>
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
                <i class="fas fa-save"></i> Create Warehouse
            </button>
            <a href="{{ route('company.warehouses.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-generate warehouse code
        $('input[name="name"]').on('blur', function() {
            var name = $(this).val();
            if (name && !$('#warehouseCode').val()) {
                var code = 'WH-' + name.substring(0, 3).toUpperCase() + '-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                $('#warehouseCode').val(code);
            }
        });

        // Form submission
        $('#warehouseForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });
    });
</script>
@endpush