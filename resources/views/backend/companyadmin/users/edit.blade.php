@extends('layouts.app')

@section('title','Edit User')
@section('page-title','Edit User')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit User
        </h3>
    </div>

    <form method="POST" action="{{ route('company.users.update', $user->id) }}" id="userForm">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Email Address <span class="text-danger">*</span></label>
                        <input type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            required>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                            @foreach(($roles ?? ['user']) as $r)
                            <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$r)) }}
                            </option>
                            @endforeach
                        </select>
                        @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Reset Password (Optional)</label>
                        <input type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Leave blank to keep current password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> If you set a password here, it will override old one.
                        </small>
                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update User
            </button>
            <a href="{{ route('company.users.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#userForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
        });
    });
</script>
@endpush