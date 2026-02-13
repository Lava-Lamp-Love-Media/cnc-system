@extends('layouts.app')

@section('title', 'Create Operator')
@section('page-title', 'Add New Operator')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Register New Operator
        </h3>
    </div>

    <form method="POST" action="{{ route('company.operators.store') }}" id="operatorForm">
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
                        <label>Operator Code <span class="text-danger">*</span></label>
                        <input type="text"
                            name="operator_code"
                            id="operatorCode"
                            class="form-control @error('operator_code') is-invalid @enderror"
                            value="{{ old('operator_code') }}"
                            placeholder="e.g., OPR-001"
                            required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Unique identifier for this operator
                        </small>
                        @error('operator_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Enter operator name"
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
                            value="{{ old('email') }}"
                            placeholder="operator@example.com">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone') }}"
                            placeholder="+1 234 567 8900">
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
                            <option value="trainee" {{ old('skill_level') == 'trainee' ? 'selected' : '' }}>
                                Trainee
                            </option>
                            <option value="junior" {{ old('skill_level', 'junior') == 'junior' ? 'selected' : '' }}>
                                Junior
                            </option>
                            <option value="senior" {{ old('skill_level') == 'senior' ? 'selected' : '' }}>
                                Senior
                            </option>
                            <option value="expert" {{ old('skill_level') == 'expert' ? 'selected' : '' }}>
                                Expert
                            </option>
                        </select>
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

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes"
                            class="form-control"
                            rows="6"
                            placeholder="Additional information, certifications, specializations...">{{ old('notes') }}</textarea>
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
                <i class="fas fa-save"></i> Register Operator
            </button>
            <a href="{{ route('company.operators.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-generate operator code suggestion
        $('input[name="name"]').on('blur', function() {
            var name = $(this).val();
            if (name && !$('#operatorCode').val()) {
                var initials = name.split(' ').map(word => word[0]).join('').toUpperCase();
                var code = 'OPR-' + initials + '-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                $('#operatorCode').val(code);
            }
        });

        // Form submission
        $('#operatorForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });
    });
</script>
@endpush