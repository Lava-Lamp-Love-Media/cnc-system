@extends('layouts.app')

@section('title', 'Operation Details')
@section('page-title', $operation->name)

@section('content')

<div class="row">
    <!-- Operation Info -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-tools fa-5x text-primary"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $operation->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $operation->operation_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $operation->status_badge !!}</span>
                    </li>
                    @if($operation->hourly_rate)
                    <li class="list-group-item">
                        <b>Hourly Rate</b>
                        <span class="float-right">
                            <span class="badge badge-success">
                                ${{ number_format($operation->hourly_rate, 2) }}/hr
                            </span>
                        </span>
                    </li>
                    @endif
                </ul>

                <a href="{{ route('company.operations.edit', $operation->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Operation
                </a>
                <a href="{{ route('company.operations.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Operation Details -->
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Operation Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Operation Code:</dt>
                    <dd class="col-sm-8">
                        <code>{{ $operation->operation_code }}</code>
                    </dd>

                    <dt class="col-sm-4">Operation Name:</dt>
                    <dd class="col-sm-8">{{ $operation->name }}</dd>

                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">
                        @if($operation->description)
                        {{ $operation->description }}
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Hourly Rate:</dt>
                    <dd class="col-sm-8">
                        @if($operation->hourly_rate)
                        ${{ number_format($operation->hourly_rate, 2) }}/hour
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $operation->status_badge !!}</dd>

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $operation->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $operation->updated_at->diffForHumans() }}</dd>
                </dl>
            </div>
        </div>

        <!-- Activity Timeline -->
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
                        <i class="fas fa-plus bg-success"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="far fa-clock"></i> {{ $operation->created_at->diffForHumans() }}
                            </span>
                            <h3 class="timeline-header">Operation Created</h3>
                            <div class="timeline-body">
                                {{ $operation->name }} operation was added to the system.
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