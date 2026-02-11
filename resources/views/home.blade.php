@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', Auth::user()->role === 'admin' ? 'Admin Dashboard' : ucfirst(Auth::user()->role) . ' Dashboard')

@section('content')
<!-- Role-specific stats -->
<div class="row">
    @if(Auth::user()->role === 'admin')
    <!-- Admin Stats -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>Total Quotes</p>
            </div>
            <div class="icon"><i class="fas fa-file-alt"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53</h3>
                <p>Active Orders</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>
                <p>Pending Invoices</p>
            </div>
            <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>6</h3>
                <p>Total Users</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    @elseif(Auth::user()->role === 'shop')
    <!-- Shop Stats -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>12</h3>
                <p>My Active Orders</p>
            </div>
            <div class="icon"><i class="fas fa-tasks"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>8</h3>
                <p>Completed Today</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>3</h3>
                <p>Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    @else
    <!-- Default Stats -->
    <div class="col-lg-6 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>24</h3>
                <p>My Tasks</p>
            </div>
            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>15</h3>
                <p>Completed</p>
            </div>
            <div class="icon"><i class="fas fa-check"></i></div>
        </div>
    </div>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Welcome, {{ Auth::user()->name }}!</h3>
    </div>
    <div class="card-body">
        <p><strong>Your Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
        <p>You have access to {{ Auth::user()->role === 'admin' ? 'all system features' : 'role-specific features' }}.</p>
    </div>
</div>
@endsection