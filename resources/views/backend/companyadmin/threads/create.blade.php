@extends('layouts.app')

@section('title', 'Create Thread')
@section('page-title', 'Add New Thread Specification')

@section('content')

<form method="POST" action="{{ route('company.threads.store') }}" id="threadForm">
    @csrf

    <div class="card" style="border-top: 3px solid #6f42c1;">
        <div class="card-header" style="background-color: #6f42c1; color: white;">
            <h3 class="card-title">
                <i class="fas fa-spinner"></i> Thread Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thread Code <span class="text-danger">*</span></label>
                        <input type="text" name="thread_code"
                            class="form-control @error('thread_code') is-invalid @enderror"
                            value="{{ old('thread_code') }}"
                            placeholder="e.g., THR-M8-1.25-EXT" required>
                        @error('thread_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thread Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., M8×1.25 External Thread" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Type <span class="text-danger">*</span></label>
                        <select name="thread_type" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            <option value="external" {{ old('thread_type') == 'external' ? 'selected' : '' }}>
                                External (Bolts/Screws)
                            </option>
                            <option value="internal" {{ old('thread_type') == 'internal' ? 'selected' : '' }}>
                                Internal (Nuts/Holes)
                            </option>
                        </select>
                        <small class="text-muted">External = on bolts, Internal = in nuts/holes</small>
                    </div>
                </div>
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
                    </div>
                </div>
            </div>

            <div class="row">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Class</label>
                        <input type="text" name="thread_class"
                            class="form-control"
                            value="{{ old('thread_class') }}"
                            placeholder="e.g., 6g (ext) or 6H (int)">
                        <small class="text-muted">External: 6g, 2A | Internal: 6H, 2B</small>
                    </div>
                </div>
                <div class="col-md-4">
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
                        <small class="text-muted">Multiple sizes available (comma separated)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thread Options (Optional)</label>
                        <input type="text" name="thread_options_input" id="thread_options_input"
                            class="form-control"
                            placeholder="e.g., standard, fine, coarse (comma separated)">
                        <small class="text-muted">Special options (comma separated)</small>
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
                        <label>Thread Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="thread_price"
                            class="form-control"
                            value="{{ old('thread_price', '0.00') }}" required>
                        <small class="text-muted">Base threading price</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Option Price ($)</label>
                        <input type="number" step="0.01" name="option_price"
                            class="form-control"
                            value="{{ old('option_price', '0.00') }}">
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
            <button type="submit" class="btn btn-lg" id="submitBtn" style="background-color: #6f42c1; border-color: #6f42c1; color: white;">
                <i class="fas fa-save"></i> Create Thread
            </button>
            <a href="{{ route('company.threads.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#threadForm').on('submit', function(e) {
        // Thread Sizes
        var threadSizesInput = $('#thread_sizes_input').val();
        if (threadSizesInput) {
            var threadSizes = threadSizesInput.split(',').map(s => s.trim()).filter(s => s);
            threadSizes.forEach((size, index) => {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'thread_sizes[' + index + ']',
                    value: size
                }).appendTo('#threadForm');
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
                }).appendTo('#threadForm');
            });
        }

        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush