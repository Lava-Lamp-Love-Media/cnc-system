@extends('layouts.app')

@section('title', 'Machine Details')
@section('page-title', $machine->name)

@section('content')

<div class="row">
    <!-- Machine Image & Basic Info -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($machine->image)
                    <img class="img-fluid rounded"
                        src="{{ asset('storage/' . $machine->image) }}"
                        alt="{{ $machine->name }}"
                        style="max-height: 300px;">
                    @else
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-industry fa-5x text-muted"></i>
                    </div>
                    @endif
                </div>

                <h3 class="profile-username text-center mt-3">{{ $machine->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $machine->machine_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $machine->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Operating Hours</b>
                        <span class="float-right badge badge-info">
                            {{ number_format($machine->operating_hours) }} hrs
                        </span>
                    </li>
                    @if($machine->age)
                    <li class="list-group-item">
                        <b>Age</b>
                        <span class="float-right">{{ $machine->age }} years</span>
                    </li>
                    @endif
                    @if($machine->location)
                    <li class="list-group-item">
                        <b>Location</b>
                        <span class="float-right">{{ $machine->location }}</span>
                    </li>
                    @endif
                </ul>

                <a href="{{ route('company.machines.edit', $machine->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Machine
                </a>
                <a href="{{ route('company.machines.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Maintenance Alert -->
        @if($machine->needsMaintenance())
        <div class="card card-{{ $machine->isOverdue() ? 'danger' : 'warning' }} card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Maintenance {{ $machine->isOverdue() ? 'Overdue' : 'Due Soon' }}
                </h3>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <strong>Next Maintenance:</strong><br>
                    {{ $machine->next_maintenance_date->format('M d, Y') }}
                    ({{ $machine->next_maintenance_date->diffForHumans() }})
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- Machine Details -->
    <div class="col-md-8">
        <!-- Technical Specifications -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Technical Specifications
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Manufacturer:</dt>
                            <dd class="col-sm-7">{{ $machine->manufacturer ?? '—' }}</dd>

                            <dt class="col-sm-5">Model:</dt>
                            <dd class="col-sm-7">{{ $machine->model ?? '—' }}</dd>

                            <dt class="col-sm-5">Serial Number:</dt>
                            <dd class="col-sm-7">
                                @if($machine->serial_number)
                                <code>{{ $machine->serial_number }}</code>
                                @else
                                —
                                @endif
                            </dd>

                            <dt class="col-sm-5">Year:</dt>
                            <dd class="col-sm-7">{{ $machine->year_of_manufacture ?? '—' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Purchase Date:</dt>
                            <dd class="col-sm-7">
                                {{ $machine->purchase_date ? $machine->purchase_date->format('M d, Y') : '—' }}
                            </dd>

                            <dt class="col-sm-5">Purchase Price:</dt>
                            <dd class="col-sm-7">
                                {{ $machine->purchase_price ? '$' . number_format($machine->purchase_price, 2) : '—' }}
                            </dd>

                            <dt class="col-sm-5">Operating Hours:</dt>
                            <dd class="col-sm-7">
                                <strong>{{ number_format($machine->operating_hours) }} hrs</strong>
                            </dd>
                        </dl>
                    </div>
                </div>

                @if($machine->description)
                <hr>
                <h5><i class="fas fa-align-left"></i> Description</h5>
                <p class="text-muted">{{ $machine->description }}</p>
                @endif

                @if($machine->specifications)
                <hr>
                <h5><i class="fas fa-cogs"></i> Specifications</h5>
                <div class="row">
                    @foreach(json_decode($machine->specifications, true) as $key => $value)
                    <div class="col-md-6 mb-2">
                        <span class="badge badge-light border px-3 py-2 d-block">
                            <strong>{{ $key }}:</strong> {{ $value }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Maintenance Schedule -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tools"></i> Maintenance Schedule
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Last Maintenance</span>
                                <span class="info-box-number">
                                    {{ $machine->last_maintenance_date ? $machine->last_maintenance_date->format('M d, Y') : 'Never' }}
                                </span>
                                @if($machine->last_maintenance_date)
                                <small class="text-muted">
                                    {{ $machine->last_maintenance_date->diffForHumans() }}
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-{{ $machine->isOverdue() ? 'danger' : ($machine->needsMaintenance() ? 'warning' : 'success') }}">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Next Maintenance</span>
                                <span class="info-box-number">
                                    {{ $machine->next_maintenance_date ? $machine->next_maintenance_date->format('M d, Y') : 'Not Scheduled' }}
                                </span>
                                @if($machine->next_maintenance_date)
                                <small class="text-{{ $machine->isOverdue() ? 'danger' : 'muted' }}">
                                    {{ $machine->next_maintenance_date->diffForHumans() }}
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> Machine History
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline timeline-inverse">
                    <!-- Created -->
                    <div>
                        <i class="fas fa-plus bg-success"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="far fa-clock"></i> {{ $machine->created_at->diffForHumans() }}
                            </span>
                            <h3 class="timeline-header">Machine Registered</h3>
                            <div class="timeline-body">
                                {{ $machine->name }} was added to the system.
                            </div>
                        </div>
                    </div>

                    @if($machine->purchase_date)
                    <!-- Purchased -->
                    <div>
                        <i class="fas fa-shopping-cart bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="far fa-clock"></i> {{ $machine->purchase_date->format('M d, Y') }}
                            </span>
                            <h3 class="timeline-header">Machine Purchased</h3>
                            <div class="timeline-body">
                                @if($machine->purchase_price)
                                Purchase Price: ${{ number_format($machine->purchase_price, 2) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($machine->last_maintenance_date)
                    <!-- Last Maintenance -->
                    <div>
                        <i class="fas fa-tools bg-warning"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="far fa-clock"></i> {{ $machine->last_maintenance_date->format('M d, Y') }}
                            </span>
                            <h3 class="timeline-header">Maintenance Completed</h3>
                            <div class="timeline-body">
                                Last maintenance service performed.
                            </div>
                        </div>
                    </div>
                    @endif

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