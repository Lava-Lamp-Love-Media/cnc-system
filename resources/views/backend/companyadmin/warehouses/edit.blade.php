@extends('layouts.app')

@section('title', 'Edit Warehouse')
@section('page-title', 'Edit Warehouse')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Warehouse: {{ $warehouse->name }}
        </h3>
    </div>

    <form method="POST" action="{{ route('company.warehouses.update', $warehouse->id) }}" id="warehouseForm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <!-- Left Column: Basic Info -->
                <div class="col-md-6">
                    <h5 class="text-warning">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Warehouse Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="warehouse_code"
                            class="form-control @error('warehouse_code') is-invalid @enderror"
                            value="{{ old('warehouse_code', $warehouse->warehouse_code) }}"
                            required>
                        @error('warehouse_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Warehouse Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $warehouse->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Warehouse Type <span class="text-danger">*</span></label>
                        <select name="warehouse_type" class="form-control" required>
                            <option value="main" {{ old('warehouse_type', $warehouse->warehouse_type) == 'main' ? 'selected' : '' }}>
                                Main Warehouse
                            </option>
                            <option value="secondary" {{ old('warehouse_type', $warehouse->warehouse_type) == 'secondary' ? 'selected' : '' }}>
                                Secondary Warehouse
                            </option>
                            <option value="raw_material" {{ old('warehouse_type', $warehouse->warehouse_type) == 'raw_material' ? 'selected' : '' }}>
                                Raw Material Storage
                            </option>
                            <option value="finished_goods" {{ old('warehouse_type', $warehouse->warehouse_type) == 'finished_goods' ? 'selected' : '' }}>
                                Finished Goods Storage
                            </option>
                            <option value="tools" {{ old('warehouse_type', $warehouse->warehouse_type) == 'tools' ? 'selected' : '' }}>
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
                                    value="{{ old('storage_capacity', $warehouse->storage_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Unit <span class="text-danger">*</span></label>
                                <select name="capacity_unit" class="form-control" required>
                                    <option value="sqm" {{ old('capacity_unit', $warehouse->capacity_unit) == 'sqm' ? 'selected' : '' }}>SQM</option>
                                    <option value="cbm" {{ old('capacity_unit', $warehouse->capacity_unit) == 'cbm' ? 'selected' : '' }}>CBM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $warehouse->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $warehouse->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                            <option value="maintenance" {{ old('status', $warehouse->status) == 'maintenance' ? 'selected' : '' }}>
                                Under Maintenance
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="3">{{ old('description', $warehouse->description) }}</textarea>
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
                            value="{{ old('manager_name', $warehouse->manager_name) }}">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $warehouse->phone) }}">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $warehouse->email) }}">
                    </div>

                    <div class="form-group">
                        <label>Street Address</label>
                        <input type="text"
                            name="address"
                            class="form-control"
                            value="{{ old('address', $warehouse->address) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text"
                                    name="city"
                                    class="form-control"
                                    value="{{ old('city', $warehouse->city) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text"
                                    name="state"
                                    class="form-control"
                                    value="{{ old('state', $warehouse->state) }}">
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
                                    value="{{ old('zip_code', $warehouse->zip_code) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text"
                                    name="country"
                                    class="form-control"
                                    value="{{ old('country', $warehouse->country) }}">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Warehouse
            </button>
            <a href="{{ route('company.warehouses.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.warehouses.show', $warehouse->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $('#warehouseForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
</script>
@endpush