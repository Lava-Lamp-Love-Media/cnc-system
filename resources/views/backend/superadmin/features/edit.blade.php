@extends('layouts.app')

@section('title', 'Edit Feature')
@section('page-title', 'Edit Feature')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Feature
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.features.update', $feature->id) }}" id="featureForm">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Feature Name <span class="text-danger">*</span></label>
                <input type="text"
                    name="name"
                    id="featureName"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $feature->name) }}"
                    required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug (System Name) <span class="text-danger">*</span></label>
                <input type="text"
                    name="slug"
                    id="featureSlug"
                    class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $feature->slug) }}"
                    required>
                @error('slug')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description"
                    class="form-control"
                    rows="3">{{ old('description', $feature->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ old('is_active', $feature->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $feature->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Feature
            </button>

            <a href="{{ route('superadmin.features.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-generate slug from name
        $('#featureName').on('keyup', function() {
            var name = $(this).val();
            var slug = name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
            $('#featureSlug').val(slug);
        });

        // Form submission
        $('#featureForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
        });
    });
</script>
@endpush