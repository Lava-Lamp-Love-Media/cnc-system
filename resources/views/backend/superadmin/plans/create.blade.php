@extends('layouts.app')

@section('title', 'Create Plan')
@section('page-title', 'Create New Plan')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Add Plan
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.plans.store') }}">
        @csrf

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Plan Name</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Basic / Pro / Enterprise"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="basic / pro"
                            required>
                        @error('slug')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            required>
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Duration (Days)</label>
                        <input type="number" name="duration_days"
                            class="form-control @error('duration_days') is-invalid @enderror"
                            value="30"
                            required>
                        @error('duration_days')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-6">

                    <label>Assign Features</label>

                    <div class="border p-3" style="max-height:300px; overflow-y:auto;">

                        @foreach($features as $feature)
                        <div class="form-check">
                            <input type="checkbox"
                                name="features[]"
                                value="{{ $feature->id }}"
                                class="form-check-input"
                                id="feature_{{ $feature->id }}">

                            <label class="form-check-label"
                                for="feature_{{ $feature->id }}">
                                {{ $feature->name }}
                            </label>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Plan
            </button>

            <a href="{{ route('superadmin.plans.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>

@endsection