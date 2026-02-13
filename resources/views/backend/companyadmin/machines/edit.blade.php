@extends('layouts.app')

@section('title', 'Edit Machine')
@section('page-title', 'Edit Machine')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Machine: {{ $machine->name }}
        </h3>
    </div>

    <form method="POST" action="{{ route('company.machines.update', $machine->id) }}" enctype="multipart/form-data" id="machineForm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <!-- Left Column: Basic Information -->
                <div class="col-md-6">
                    <h5 class="text-warning">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Machine Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $machine->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Machine Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="machine_code"
                            class="form-control @error('machine_code') is-invalid @enderror"
                            value="{{ old('machine_code', $machine->machine_code) }}"
                            required>
                        @error('machine_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Manufacturer</label>
                        <input type="text"
                            name="manufacturer"
                            class="form-control"
                            value="{{ old('manufacturer', $machine->manufacturer) }}">
                    </div>

                    <div class="form-group">
                        <label>Model</label>
                        <input type="text"
                            name="model"
                            class="form-control"
                            value="{{ old('model', $machine->model) }}">
                    </div>

                    <div class="form-group">
                        <label>Serial Number</label>
                        <input type="text"
                            name="serial_number"
                            class="form-control"
                            value="{{ old('serial_number', $machine->serial_number) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year of Manufacture</label>
                                <input type="number"
                                    name="year_of_manufacture"
                                    class="form-control"
                                    value="{{ old('year_of_manufacture', $machine->year_of_manufacture) }}"
                                    min="1900"
                                    max="{{ date('Y') + 1 }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input type="date"
                                    name="purchase_date"
                                    class="form-control"
                                    value="{{ old('purchase_date', $machine->purchase_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Purchase Price ($)</label>
                        <input type="number"
                            step="0.01"
                            name="purchase_price"
                            class="form-control"
                            value="{{ old('purchase_price', $machine->purchase_price) }}">
                    </div>

                    <div class="form-group">
                        <label>Machine Image</label>
                        @if($machine->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $machine->image) }}"
                                alt="{{ $machine->name }}"
                                class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>
                        @endif
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input"
                                id="machineImage"
                                name="image"
                                accept="image/*">
                            <label class="custom-file-label" for="machineImage">
                                {{ $machine->image ? 'Change image' : 'Choose file' }}
                            </label>
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
                            <option value="active" {{ old('status', $machine->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="maintenance" {{ old('status', $machine->status) == 'maintenance' ? 'selected' : '' }}>
                                Under Maintenance
                            </option>
                            <option value="inactive" {{ old('status', $machine->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                            <option value="broken" {{ old('status', $machine->status) == 'broken' ? 'selected' : '' }}>
                                Broken
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text"
                            name="location"
                            class="form-control"
                            value="{{ old('location', $machine->location) }}">
                    </div>

                    <div class="form-group">
                        <label>Operating Hours</label>
                        <input type="number"
                            name="operating_hours"
                            class="form-control"
                            value="{{ old('operating_hours', $machine->operating_hours) }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label>Last Maintenance Date</label>
                        <input type="date"
                            name="last_maintenance_date"
                            class="form-control"
                            value="{{ old('last_maintenance_date', $machine->last_maintenance_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label>Next Maintenance Date</label>
                        <input type="date"
                            name="next_maintenance_date"
                            class="form-control"
                            value="{{ old('next_maintenance_date', $machine->next_maintenance_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="4">{{ old('description', $machine->description) }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Machine
            </button>
            <a href="{{ route('company.machines.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.machines.show', $machine->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
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

        // Form submission
        $('#machineForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
        });
    });
</script>
@endpush