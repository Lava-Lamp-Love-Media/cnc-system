@extends('layouts.app')

@section('title','Create User')
@section('page-title','Add New User')

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus"></i> Create New User
                </h3>
            </div>

            <form method="POST" action="{{ route('company.users.store') }}">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label for="name">
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter full name"
                                value="{{ old('name') }}"
                                required>
                        </div>
                        @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="user@example.com"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            A secure password will be automatically generated and displayed after creation.
                        </small>
                    </div>

                    <div class="callout callout-info">
                        <h5><i class="fas fa-info-circle"></i> Important:</h5>
                        <p class="mb-0">User credentials will be displayed after creation. Make sure to copy and share them securely with the user.</p>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create User
                    </button>
                    <a href="{{ route('company.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection