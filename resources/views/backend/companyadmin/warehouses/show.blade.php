@extends('layouts.app')

@section('title', 'Warehouse Details')
@section('page-title', $warehouse->name)

@section('content')

    <div class="row">
        <!-- Warehouse Profile -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="bg-light p-5 rounded">
                            <i class="fas fa-warehouse fa-5x text-primary"></i>
                        </div>
                    </div>

                    <h3 class="profile-username text-center mt-3">{{ $warehouse->name }}</h3>

                    <p class="text-muted text-center">
                        <span class="badge badge-light border">
                            <code>{{ $warehouse->warehouse_code }}</code>
                        </span>
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Type</b>
                            <span class="float-right">{!! $warehouse->type_badge !!}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b>
                            <span class="float-right">{!! $warehouse->status_badge !!}</span>
                        </li>
                        @if ($warehouse->storage_capacity)
                            <li class="list-group-item">
                                <b>Capacity</b>
                                <span class="float-right">
                                    <span class="badge badge-info">
                                        {{ number_format($warehouse->storage_capacity) }}
                                        {{ strtoupper($warehouse->capacity_unit) }}
                                    </span>
                                </span>
                            </li>
                        @endif
                        @if ($warehouse->manager_name)
                            <li class="list-group-item">
                                <b>Manager</b>
                                <span class="float-right">{{ $warehouse->manager_name }}</span>
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('company.warehouses.edit', $warehouse->id) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit Warehouse
                    </a>
                    <a href="{{ route('company.warehouses.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Warehouse Details -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Warehouse Information
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Warehouse Code:</dt>
                        <dd class="col-sm-8">
                            <code>{{ $warehouse->warehouse_code }}</code>
                        </dd>

                        <dt class="col-sm-4">Warehouse Name:</dt>
                        <dd class="col-sm-8">{{ $warehouse->name }}</dd>

                        <dt class="col-sm-4">Type:</dt>
                        <dd class="col-sm-8">{!! $warehouse->type_badge !!}</dd>

                        <dt class="col-sm-4">Storage Capacity:</dt>
                        <dd class="col-sm-8">
                            @if ($warehouse->storage_capacity)
                                {{ number_format($warehouse->storage_capacity) }}
                                {{ strtoupper($warehouse->capacity_unit) }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">{!! $warehouse->status_badge !!}</dd>

                        <dt class="col-sm-4">Description:</dt>
                        <dd class="col-sm-8">
                            @if ($warehouse->description)
                                {{ $warehouse->description }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-address-book"></i> Contact Information
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Manager:</dt>
                        <dd class="col-sm-8">{{ $warehouse->manager_name ?? '—' }}</dd>

                        <dt class="col-sm-4">Phone:</dt>
                        <dd class="col-sm-8">
                            @if ($warehouse->phone)
                                <a href="tel:{{ $warehouse->phone }}">{{ $warehouse->phone }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">
                            @if ($warehouse->email)
                                <a href="mailto:{{ $warehouse->email }}">{{ $warehouse->email }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Address:</dt>
                        <dd class="col-sm-8">
                            @if ($warehouse->full_address)
                                <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                {{ $warehouse->full_address }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i> Activity Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        <!-- Created -->
                        <div>
                            <i class="fas fa-warehouse bg-success"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="far fa-clock"></i> {{ $warehouse->created_at->diffForHumans() }}
                                </span>
                                <h3 class="timeline-header">Warehouse Registered</h3>
                                <div class="timeline-body">
                                    {{ $warehouse->name }} was added to the system.
                                </div>
                            </div>
                        </div>

                        <!-- End -->
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
