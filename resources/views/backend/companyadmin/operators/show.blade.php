@extends('layouts.app')

@section('title', 'Operator Details')
@section('page-title', $operator->name)

@section('content')

<div class="row">
    <!-- Operator Profile -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-user-hard-hat fa-5x text-primary"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $operator->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $operator->operator_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $operator->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Skill Level</b>
                        <span class="float-right">{!! $operator->skill_badge !!}</span>
                    </li>
                    @if($operator->email)
                    <li class="list-group-item">
                        <b>Email</b>
                        <span class="float-right">
                            <a href="mailto:{{ $operator->email }}">{{ $operator->email }}</a>
                        </span>
                    </li>
                    @endif
                    @if($operator->phone)
                    <li class="list-group-item">
                        <b>Phone</b>
                        <span class="float-right">
                            <a href="tel:{{ $operator->phone }}">{{ $operator->phone }}</a>
                        </span>
                    </li>
                    @endif
                </ul>

                <a href="{{ route('company.operators.edit', $operator->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Operator
                </a>
                <a href="{{ route('company.operators.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Operator Details -->
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Operator Information
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Operator Code:</dt>
                    <dd class="col-sm-8">
                        <code>{{ $operator->operator_code }}</code>
                    </dd>

                    <dt class="col-sm-4">Full Name:</dt>
                    <dd class="col-sm-8">{{ $operator->name }}</dd>

                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8">
                        @if($operator->email)
                        <a href="mailto:{{ $operator->email }}">{{ $operator->email }}</a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Phone:</dt>
                    <dd class="col-sm-8">
                        @if($operator->phone)
                        <a href="tel:{{ $operator->phone }}">{{ $operator->phone }}</a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Skill Level:</dt>
                    <dd class="col-sm-8">{!! $operator->skill_badge !!}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $operator->status_badge !!}</dd>

                    <dt class="col-sm-4">Registered:</dt>
                    <dd class="col-sm-8">{{ $operator->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $operator->updated_at->diffForHumans() }}</dd>
                </dl>

                @if($operator->notes)
                <hr>
                <h5><i class="fas fa-sticky-note"></i> Notes</h5>
                <p class="text-muted">{{ $operator->notes }}</p>
                @endif
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
                        <i class="fas fa-user-plus bg-success"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="far fa-clock"></i> {{ $operator->created_at->diffForHumans() }}
                            </span>
                            <h3 class="timeline-header">Operator Registered</h3>
                            <div class="timeline-body">
                                {{ $operator->name }} was added to the system as {{ $operator->skill_level }}.
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