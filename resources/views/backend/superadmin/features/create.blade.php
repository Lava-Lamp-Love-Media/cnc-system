@extends('layouts.app')

@section('title', 'Create Feature')
@section('page-title', 'Create New Feature')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Add Feature
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.features.store') }}">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Feature Name</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Example: Quotes Management"
                    required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug (System Name)</label>
                <input type="text" name="slug"
                    class="form-control @error('slug') is-invalid @enderror"
                    placeholder="quotes"
                    required>
                <small class="text-muted">
                    Use lowercase. Example: quotes, orders, invoices
                </small>
                @error('slug')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description"
                    class="form-control"
                    rows="3"
                    placeholder="Optional feature description"></textarea>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Feature
            </button>

            <a href="{{ route('superadmin.features.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection