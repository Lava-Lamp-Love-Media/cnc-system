@extends('layouts.app')

@section('title', 'Edit Thread')
@section('page-title', 'Edit Thread Specification')

@section('content')

<form method="POST" action="{{ route('company.threads.update', $thread->id) }}" id="threadForm">
    @csrf
    @method('PUT')

    <div class="card" style="border-top: 3px solid #6f42c1;">
        <div class="card-header" style="background-color: #6f42c1; color: white;">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Thread: {{ $thread->name }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thread Code <span class="text-danger">*</span></label>
                        <input type="text" name="thread_code"
                            class="form-control @error('thread_code') is-invalid @enderror"
                            value="{{ old('thread_code', $thread->thread_code) }}" required>
                        @error('thread_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thread Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control"
                            value="{{ old('name', $thread->name) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Type <span class="text-danger">*</span></label>
                        <select name="thread_type" class="form-control" required>
                            <option value="external" {{ old('thread_type', $thread->thread_type) == 'external' ? 'selected' : '' }}>
                                External (Bolts/Screws)
                            </option>
                            <option value="internal" {{ old('thread_type', $thread->thread_type) == 'internal' ? 'selected' : '' }}>
                                Internal (Nuts/Holes)
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diameter (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="diameter"
                            class="form-control"
                            value="{{ old('diameter', $thread->diameter) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pitch (mm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="pitch"
                            class="form-control"
                            value="{{ old('pitch', $thread->pitch) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Standard <span class="text-danger">*</span></label>
                        <select name="thread_standard" class="form-control" required>
                            <option value="metric" {{ old('thread_standard', $thread->thread_standard) == 'metric' ? 'selected' : '' }}>Metric (ISO)</option>
                            <option value="UNC" {{ old('thread_standard', $thread->thread_standard) == 'UNC' ? 'selected' : '' }}>UNC (Coarse)</option>
                            <option value="UNF" {{ old('thread_standard', $thread->thread_standard) == 'UNF' ? 'selected' : '' }}>UNF (Fine)</option>
                            <option value="BSP" {{ old('thread_standard', $thread->thread_standard) == 'BSP' ? 'selected' : '' }}>BSP (Pipe)</option>
                            <option value="NPT" {{ old('thread_standard', $thread->thread_standard) == 'NPT' ? 'selected' : '' }}>NPT (Pipe)</option>
                            <option value="national_coarse" {{ old('thread_standard', $thread->thread_standard) == 'national_coarse' ? 'selected' : '' }}>National Coarse</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thread Class</label>
                        <input type="text" name="thread_class"
                            class="form-control"
                            value="{{ old('thread_class', $thread->thread_class) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Direction <span class="text-danger">*</span></label>
                        <select name="direction" class="form-control" required>
                            <option value="right" {{ old('direction', $thread->direction) == 'right' ? 'selected' : '' }}>Right-Hand</option>
                            <option value="left" {{ old('direction', $thread->direction) == 'left' ? 'selected' : '' }}>Left-Hand</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thread Sizes</label>
                        <input type="text" name="thread_sizes_input" id="thread_sizes_input"
                            class="form-control"
                            value="{{ is_array($thread->thread_sizes) ? implode(', ', $thread->thread_sizes) : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thread Options</label>
                        <input type="text" name="thread_options_input" id="thread_options_input"
                            class="form-control"
                            value="{{ is_array($thread->thread_options) ? implode(', ', $thread->thread_options) : '' }}">
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
                        <label>Thread Price ($)</label>
                        <input type="number" step="0.01" name="thread_price"
                            class="form-control"
                            value="{{ old('thread_price', $thread->thread_price) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Option Price ($)</label>
                        <input type="number" step="0.01" name="option_price"
                            class="form-control"
                            value="{{ old('option_price', $thread->option_price) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Pitch Price ($)</label>
                        <input type="number" step="0.01" name="pitch_price"
                            class="form-control"
                            value="{{ old('pitch_price', $thread->pitch_price) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class Price ($)</label>
                        <input type="number" step="0.01" name="class_price"
                            class="form-control"
                            value="{{ old('class_price', $thread->class_price) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Size Price ($)</label>
                        <input type="number" step="0.01" name="size_price"
                            class="form-control"
                            value="{{ old('size_price', $thread->size_price) }}">
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
                            value="{{ old('sort_order', $thread->sort_order) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $thread->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $thread->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $thread->description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-lg" id="submitBtn" style="background-color: #6f42c1; border-color: #6f42c1; color: white;">
                <i class="fas fa-save"></i> Update Thread
            </button>
            <a href="{{ route('company.threads.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.threads.show', $thread->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#threadForm').on('submit', function(e) {
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

        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
});
</script>
@endpush