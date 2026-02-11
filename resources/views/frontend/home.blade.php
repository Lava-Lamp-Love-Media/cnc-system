@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Welcome Card -->
<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-2">
                            <i class="fas fa-hand-wave"></i>
                            Welcome back, {{ Auth::user()->name }}!
                        </h3>
                        <p class="mb-0">
                            You're logged in as <strong>{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</strong>
                            @if(Auth::user()->company)
                            at <strong>{{ Auth::user()->company->name }}</strong>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-right d-none d-md-block">
                        <i class="fas fa-chart-line fa-5x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row">
    @if(Auth::user()->isSuperAdmin())
    <!-- Super Admin Stats -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ \App\Models\Company::count() }}</h3>
                <p>Total Companies</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="{{ route('superadmin.companies.index') }}" class="small-box-footer">
                View Details <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>{{ \App\Models\TrialRequest::where('status', 'pending')->count() }}</h3>
                <p>Pending Trials</p>
            </div>
            <div class="icon">
                <i class="fas fa-inbox"></i>
            </div>
            <a href="{{ route('superadmin.trial_requests.index') }}" class="small-box-footer">
                Review Now <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-danger">
            <div class="inner">
                <h3>{{ \App\Models\Plan::count() }}</h3>
                <p>Active Plans</p>
            </div>
            <div class="icon">
                <i class="fas fa-crown"></i>
            </div>
            <a href="{{ route('superadmin.plans.index') }}" class="small-box-footer">
                Manage Plans <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @elseif(Auth::user()->isCompanyAdmin())
    <!-- Company Admin Stats -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>{{ Auth::user()->company->users()->where('role', 'user')->count() }}</h3>
                <p>Company Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('company.users.index') }}" class="small-box-footer">
                Manage Users <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ Auth::user()->company->plan->features->count() }}</h3>
                <p>Active Features</p>
            </div>
            <div class="icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Features <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ Auth::user()->company->plan->name }}</h3>
                <p>Current Plan</p>
            </div>
            <div class="icon">
                <i class="fas fa-crown"></i>
            </div>
            <a href="#" class="small-box-footer">
                Plan Details <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>{{ now()->diffInDays(Auth::user()->company->subscription_end) }}</h3>
                <p>Days Remaining</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="#" class="small-box-footer">
                Renew Now <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @else
    <!-- Regular User Stats -->
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>24</h3>
                <p>My Active Tasks</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Tasks <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>18</h3>
                <p>Completed</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="#" class="small-box-footer">
                View History <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>6</h3>
                <p>Pending Review</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer">
                Check Now <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Quick Actions & Info -->
<div class="row">
    @if(Auth::user()->isSuperAdmin())
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-rocket"></i> Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <a href="{{ route('superadmin.companies.create') }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-plus"></i> Create New Company
                </a>
                <a href="{{ route('superadmin.plans.create') }}" class="btn btn-success btn-block mb-2">
                    <i class="fas fa-crown"></i> Create New Plan
                </a>
                <a href="{{ route('superadmin.features.create') }}" class="btn btn-info btn-block">
                    <i class="fas fa-layer-group"></i> Create New Feature
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> System Overview
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Active Companies</span>
                    <span class="badge badge-success">{{ \App\Models\Company::where('status', 'active')->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Trial Companies</span>
                    <span class="badge badge-warning">{{ \App\Models\Company::where('status', 'trial')->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Total Features</span>
                    <span class="badge badge-info">{{ \App\Models\Feature::count() }}</span>
                </div>
            </div>
        </div>
    </div>

    @elseif(Auth::user()->isCompanyAdmin())
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-rocket"></i> Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <a href="{{ route('company.users.create') }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-user-plus"></i> Add New User
                </a>
                <a href="#" class="btn btn-success btn-block mb-2">
                    <i class="fas fa-building"></i> Company Settings
                </a>
                <a href="#" class="btn btn-info btn-block">
                    <i class="fas fa-chart-bar"></i> View Reports
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Plan Information
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Plan:</strong> {{ Auth::user()->company->plan->name }}</p>
                <p><strong>Status:</strong> <span class="badge badge-success">{{ ucfirst(Auth::user()->company->status) }}</span></p>
                <p><strong>Expires:</strong> {{ Auth::user()->company->subscription_end->format('M d, Y') }}</p>
                <p><strong>Features:</strong> {{ Auth::user()->company->plan->features->pluck('name')->implode(', ') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection