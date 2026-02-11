@extends('layouts.app')

@section('title','Create Company')
@section('page-title','Create Company & Admin')

@section('content')

<div class="card card-primary">

    <form method="POST" action="{{ route('superadmin.companies.store') }}">
        @csrf

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <h5>Company Info</h5>

                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Company Email</label>
                        <input type="email" name="company_email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Select Plan</label>
                        <select name="plan_id" class="form-control" required>
                            <option value="">-- Select Plan --</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->name }} (${{ $plan->price }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5>Company Admin</h5>

                    <div class="form-group">
                        <label>Admin Name</label>
                        <input type="text" name="admin_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Admin Email</label>
                        <input type="email" name="admin_email" class="form-control" required>
                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Create Company
            </button>
            <a href="{{ route('superadmin.companies.index') }}" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection