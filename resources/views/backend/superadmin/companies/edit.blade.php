@extends('layouts.app')

@section('title', 'Edit Company')
@section('page-title', 'Edit Company')

@section('content')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Company
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.companies.update', $company->id) }}" id="companyForm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">

                <!-- Left Side: Company Info -->
                <div class="col-md-6">
                    <h5 class="text-warning">
                        <i class="fas fa-building"></i> Company Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="company_name"
                            class="form-control @error('company_name') is-invalid @enderror"
                            value="{{ old('company_name', $company->name) }}"
                            required>
                        @error('company_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Company Email <span class="text-danger">*</span></label>
                        <input type="email"
                            name="company_email"
                            class="form-control @error('company_email') is-invalid @enderror"
                            value="{{ old('company_email', $company->email) }}"
                            required>
                        @error('company_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="company_phone"
                            class="form-control"
                            value="{{ old('company_phone', $company->phone) }}"
                            placeholder="Optional">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="company_address"
                            class="form-control"
                            rows="3"
                            placeholder="Optional">{{ old('company_address', $company->address) }}</textarea>
                    </div>

                </div>

                <!-- Right Side: Plan & Status -->
                <div class="col-md-6">
                    <h5 class="text-info">
                        <i class="fas fa-cog"></i> Plan & Status
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Select Plan <span class="text-danger">*</span></label>
                        <select name="plan_id"
                            class="form-control @error('plan_id') is-invalid @enderror"
                            required>
                            <option value="">-- Select Plan --</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}"
                                {{ old('plan_id', $company->plan_id) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ${{ number_format($plan->price, 2) }}/month
                            </option>
                            @endforeach
                        </select>
                        @error('plan_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $company->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="trial" {{ old('status', $company->status) == 'trial' ? 'selected' : '' }}>Trial</option>
                            <option value="suspended" {{ old('status', $company->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Subscription Start</label>
                        <input type="date"
                            name="subscription_start"
                            class="form-control"
                            value="{{ old('subscription_start', $company->subscription_start ? $company->subscription_start->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group">
                        <label>Subscription End</label>
                        <input type="date"
                            name="subscription_end"
                            class="form-control"
                            value="{{ old('subscription_end', $company->subscription_end ? $company->subscription_end->format('Y-m-d') : '') }}">
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Company Admin:</strong>
                        @if($company->users()->where('role', 'company_admin')->first())
                        <br>{{ $company->users()->where('role', 'company_admin')->first()->name }}
                        <br><small>{{ $company->users()->where('role', 'company_admin')->first()->email }}</small>
                        @else
                        <br><span class="text-muted">No admin assigned</span>
                        @endif
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Company
            </button>
            <a href="{{ route('superadmin.companies.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $('#companyForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
    });
</script>
@endpush