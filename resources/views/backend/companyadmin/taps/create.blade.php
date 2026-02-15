@extends('layouts.app')

@section('title', 'Create Tap')
@section('page-title', 'Add New Tap Specification')

@section('content')

<form method="POST" action="{{ route('company.taps.store') }}" id="tapForm">
    @csrf

    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-screwdriver"></i> Tap Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tap Code <span class="text-danger">*</span></label>
                        <input type="text" name="tap_code"
                            class="form-control @error('tap_code') is-invalid @enderror"
                            value="{{ old('tap_code') }}"
                            placeholder="e.g., TAP-M8-1.25" required>
                        @error('tap_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tap Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., M8×1.25 Tap" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diameter (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="diameter"
                            class="form-control @error('diameter') is-invalid @enderror"
                            value="{{ old('diameter') }}"
                            placeholder="e.g., 8.000" required>
                        @error('diameter')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Major diameter</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pitch (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="pitch"
                            class="form-control @error('pitch') is-invalid @enderror"
                            value="{{ old('pitch') }}"
                            placeholder="e.g., 1.250" required>
                        @error('pitch')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Thread pitch</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Standard <span class="text-danger">*</span></label>
                        <select name="thread_standard" class="form-control" required>
                            <option value="">-- Select Standard --</option>
                            <option value="metric" {{ old('thread_standard') == 'metric' ? 'selected' : '' }}>Metric (ISO)</option>
                            <option value="UNC" {{ old('thread_standard') == 'UNC' ? 'selected' : '' }}>UNC (Coarse)</option>
                            <option value="UNF" {{ old('thread_standard') == 'UNF' ? 'selected' : '' }}>UNF (Fine)</option>
                            <option value="BSP" {{ old('thread_standard') == 'BSP' ? 'selected' : '' }}>BSP (Pipe)</option>
                            <option value="NPT" {{ old('thread_standard') == 'NPT' ? 'selected' : '' }}>NPT (Pipe)</option>
                            <option value="national_coarse" {{ old('thread_standard') == 'national_coarse' ? 'selected' : '' }}>National Coarse</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thread Class</label>
                        <input type="text" name="thread_class"
                            class="form-control"
                            value="{{ old('thread_class') }}"
                            placeholder="e.g., 6H, 2B">
                        <small class="text-muted">Tolerance class (e.g., 6H for metric, 2B for imperial)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Direction <span class="text-danger">*</span></label>
                        <select name="direction" class="form-control" required>
                            <option value="right" {{ old('direction', 'right') == 'right' ? 'selected' : '' }}>Right-Hand (Standard)</option>
                            <option value="left" {{ old('direction') == 'left' ? 'selected' : '' }}>Left-Hand (Special)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thread Sizes (Optional)</label>
                        <input type="text" name="thread_sizes_input" id="thread_sizes_input"
                            class="form-control"
                            placeholder="e.g., M8×1.25, M8×1.0 (comma separated)">
                        <small class="text-muted">Multiple sizes this tap can create (comma separated)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thread Options (Optional)</label>
                        <input type="text" name="thread_options_input" id="thread_options_input"
                            class="form-control"
                            placeholder="e.g., internal, external (comma separated)">
                        <small class="text-muted">Thread type options (comma separated)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-dollar-sign"></i> Pricing Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tap Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="tap_price"
                            class="form-control"
                            value="{{ old('tap_price', '0.00') }}" required>
                        <small class="text-muted">Base tap price</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Thread Option Price ($)</label>
                        <input type="number" step="0.01" name="thread_option_price"
                            class="form-control"
                            value="{{ old('thread_option_price', '0.00') }}">
                        <small class="text-muted">Additional for options</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Pitch Price ($)</label>
                        <input type="number" step="0.01" name="pitch_price"
                            class="form-control"
                            value="{{ old('pitch_price', '0.00') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class Price ($)</label>
                        <input type="number" step="0.01" name="class_price"
                            class="form-control"
                            value="{{ old('class_price', '0.00') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Size Price ($)</label>
                        <input type="number" step="0.01" name="size_price"
                            class="form-control"
                            value="{{ old('size_price', '0.00') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cog"></i> Additional Settings
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Optional description">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-danger btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Tap
            </button>
            <a href="{{ route('company.taps.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Convert comma-separated inputs to arrays on submit
    $('#tapForm').on('submit', function(e) {
        // Thread Sizes
        var threadSizesInput = $('#thread_sizes_input').val();
        if (threadSizesInput) {
            var threadSizes = threadSizesInput.split(',').map(s => s.trim()).filter(s => s);
            threadSizes.forEach((size, index) => {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'thread_sizes[' + index + ']',
                    value: size
                }).appendTo('#tapForm');
            });
        }

        // Thread Options
        var threadOptionsInput = $('#thread_options_input').val();
        if (threadOptionsInput) {
            var threadOptions = threadOptionsInput.split(',').map(s => s.trim()).filter(s => s);
            threadOptions.forEach((option, index) => {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'thread_options[' + index + ']',
                    value: option
                }).appendTo('#tapForm');
            });
        }

        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush