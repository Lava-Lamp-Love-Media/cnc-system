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
                            You're logged in as <strong>{{ Auth::user()->role_name }}</strong>
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
                <h3>{{ Auth::user()->company->users()->where('role', '!=', 'company_admin')->count() }}</h3>
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
                <h3>{{ Auth::user()->company->daysUntilExpiry() }}</h3>
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

    @elseif(Auth::user()->isShop())
    <!-- Shop User Stats -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>18</h3>
                <p>Active Jobs</p>
            </div>
            <div class="icon">
                <i class="fas fa-tools"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Jobs <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>12</h3>
                <p>Completed Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="#" class="small-box-footer">
                View History <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>5</h3>
                <p>Pending QC</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer">
                Check Now <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>3</h3>
                <p>Machines Available</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Machines <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @elseif(Auth::user()->isEngineer())
    <!-- Engineer Stats -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>14</h3>
                <p>Active Designs</p>
            </div>
            <div class="icon">
                <i class="fas fa-drafting-compass"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Designs <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>8</h3>
                <p>Approved Drawings</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-contract"></i>
            </div>
            <a href="#" class="small-box-footer">
                View Approved <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>6</h3>
                <p>Pending Review</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <a href="#" class="small-box-footer">
                Review Now <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>22</h3>
                <p>CAD Files</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-code"></i>
            </div>
            <a href="#" class="small-box-footer">
                File Manager <i class="fas fa-arrow-circle-right"></i>
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

<!-- Role Info Card -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Your Access Level
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Role:</strong> {{ Auth::user()->role_name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

                @if(Auth::user()->company)
                <p><strong>Company:</strong> {{ Auth::user()->company->name }}</p>
                <p><strong>Plan:</strong> {{ Auth::user()->company->plan->name }}</p>
                <p><strong>Features Available:</strong> {{ Auth::user()->company->plan->features->pluck('name')->implode(', ') }}</p>
                @endif

                <hr>

                <div class="alert alert-info">
                    <h5><i class="fas fa-user-shield"></i> Your Permissions:</h5>
                    @if(Auth::user()->isSuperAdmin())
                    <p class="mb-0">✅ Full system access - Can manage all companies, plans, and features</p>
                    @elseif(Auth::user()->isCompanyAdmin())
                    <p class="mb-0">✅ Company management - Can manage users and company settings</p>
                    @elseif(Auth::user()->isShop())
                    <p class="mb-0">✅ Shop floor access - Can manage jobs, machines, and production</p>
                    @elseif(Auth::user()->isEngineer())
                    <p class="mb-0">✅ Engineering access - Can create designs, CAD files, and technical drawings</p>
                    @else
                    <p class="mb-0">✅ Feature-based access - Access determined by company plan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection