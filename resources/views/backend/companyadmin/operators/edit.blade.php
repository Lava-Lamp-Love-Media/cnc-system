@extends('layouts.app')

@section('title', 'Edit Operator')
@section('page-title', 'Edit Operator')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Operator: {{ $operator->name }}
        </h3>
    </div>

    <form method="POST" action="{{ route('company.operators.update', $operator->id) }}" id="operatorForm">
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
                        <label>Operator Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="operator_code"
                            class="form-control @error('operator_code') is-invalid @enderror"
                            value="{{ old('operator_code', $operator->operator_code) }}"
                            required>
                        @error('operator_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $operator->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $operator->email) }}">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $operator->phone) }}">
                    </div>

                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <h5 class="text-success">
                        <i class="fas fa-cogs"></i> Work Details
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Skill Level <span class="text-danger">*</span></label>
                        <select name="skill_level" class="form-control" required>
                            <option value="trainee" {{ old('skill_level', $operator->skill_level) == 'trainee' ? 'selected' : '' }}>
                                Trainee
                            </option>
                            <option value="junior" {{ old('skill_level', $operator->skill_level) == 'junior' ? 'selected' : '' }}>
                                Junior
                            </option>
                            <option value="senior" {{ old('skill_level', $operator->skill_level) == 'senior' ? 'selected' : '' }}>
                                Senior
                            </option>
                            <option value="expert" {{ old('skill_level', $operator->skill_level) == 'expert' ? 'selected' : '' }}>
                                Expert
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $operator->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $operator->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes"
                            class="form-control"
                            rows="6">{{ old('notes', $operator->notes) }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Operator
            </button>
            <a href="{{ route('company.operators.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.operators.show', $operator->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $('#operatorForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
</script>
@endpush