@extends('layouts.app')

@section('title', 'Edit Plan')
@section('page-title', 'Edit Plan')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Plan
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.plans.update', $plan->id) }}" id="planForm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Plan Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            id="planName"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $plan->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Slug <span class="text-danger">*</span></label>
                        <input type="text"
                            name="slug"
                            id="planSlug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $plan->slug) }}"
                            required>
                        @error('slug')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Price ($) <span class="text-danger">*</span></label>
                        <input type="number"
                            step="0.01"
                            name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $plan->price) }}"
                            required>
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Duration (Days) <span class="text-danger">*</span></label>
                        <input type="number"
                            name="duration_days"
                            class="form-control @error('duration_days') is-invalid @enderror"
                            value="{{ old('duration_days', $plan->duration_days) }}"
                            required>
                        @error('duration_days')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $plan->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $plan->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="d-block">
                        <i class="fas fa-puzzle-piece"></i>
                        Assign Features
                        <span class="badge badge-info ml-2" id="featureCount">0 selected</span>
                    </label>

                    <div class="border rounded p-3 bg-light" style="max-height:320px; overflow-y:auto;">

                        @if($features->count() > 0)
                        @foreach($features as $feature)
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                name="features[]"
                                value="{{ $feature->id }}"
                                class="custom-control-input feature-checkbox"
                                id="feature_{{ $feature->id }}"
                                {{ in_array($feature->id, old('features', $plan->features->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="feature_{{ $feature->id }}">
                                <i class="fas fa-cube text-primary fa-xs mr-1"></i>
                                {{ $feature->name }}
                            </label>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-info-circle"></i>
                            <p class="mb-0">No features available</p>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Plan
            </button>

            <a href="{{ route('superadmin.plans.index') }}" class="btn btn-secondary btn-lg">
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
        $('#planName').on('keyup', function() {
            var name = $(this).val();
            var slug = name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
            $('#planSlug').val(slug);
        });

        // Count selected features
        function updateFeatureCount() {
            var count = $('.feature-checkbox:checked').length;
            $('#featureCount').text(count + ' selected');
        }

        $('.feature-checkbox').change(updateFeatureCount);
        updateFeatureCount();

        // Form submission
        $('#planForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
        });
    });
</script>
@endpush