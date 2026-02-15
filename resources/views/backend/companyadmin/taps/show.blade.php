@extends('layouts.app')

@section('title', 'Tap Details')
@section('page-title', $tap->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card card-danger card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-screwdriver fa-5x text-danger mb-3"></i>
                </div>

                <h3 class="profile-username text-center">{{ $tap->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $tap->tap_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Thread Spec</b>
                        <span class="float-right">
                            <strong>{{ $tap->thread_spec }}</strong>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Standard</b>
                        <span class="float-right">{!! $tap->standard_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Thread Class</b>
                        <span class="float-right">
                            @if($tap->thread_class)
                            <span class="badge badge-secondary">{{ $tap->thread_class }}</span>
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Direction</b>
                        <span class="float-right">{!! $tap->direction_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Tap Price</b>
                        <span class="float-right"><strong>${{ number_format($tap->tap_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $tap->status_badge !!}</span>
                    </li>
                </ul>

                <a href="{{ route('company.taps.edit', $tap->id) }}" class="btn btn-danger btn-block">
                    <i class="fas fa-edit"></i> Edit Tap
                </a>
                <a href="{{ route('company.taps.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Tap Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Tap Code:</dt>
                    <dd class="col-sm-8"><code>{{ $tap->tap_code }}</code></dd>

                    <dt class="col-sm-4">Tap Name:</dt>
                    <dd class="col-sm-8">{{ $tap->name }}</dd>

                    <dt class="col-sm-4">Diameter:</dt>
                    <dd class="col-sm-8"><strong>Ø{{ number_format($tap->diameter, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Pitch:</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($tap->pitch, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Thread Standard:</dt>
                    <dd class="col-sm-8">{!! $tap->standard_badge !!}</dd>

                    <dt class="col-sm-4">Thread Class:</dt>
                    <dd class="col-sm-8">
                        @if($tap->thread_class)
                        <span class="badge badge-secondary">{{ $tap->thread_class }}</span>
                        @else
                        <span class="text-muted">Not specified</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Direction:</dt>
                    <dd class="col-sm-8">{!! $tap->direction_badge !!}</dd>

                    @if($tap->thread_sizes && count($tap->thread_sizes) > 0)
                    <dt class="col-sm-4">Thread Sizes:</dt>
                    <dd class="col-sm-8">
                        @foreach($tap->thread_sizes as $size)
                        <span class="badge badge-info mr-1">{{ $size }}</span>
                        @endforeach
                    </dd>
                    @endif

                    @if($tap->thread_options && count($tap->thread_options) > 0)
                    <dt class="col-sm-4">Thread Options:</dt>
                    <dd class="col-sm-8">
                        @foreach($tap->thread_options as $option)
                        <span class="badge badge-primary mr-1">{{ ucfirst($option) }}</span>
                        @endforeach
                    </dd>
                    @endif

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $tap->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $tap->status_badge !!}</dd>

                    @if($tap->description)
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $tap->description }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $tap->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $tap->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-dollar-sign"></i> Pricing Breakdown
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-danger"><i class="fas fa-screwdriver"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tap Price</span>
                                <span class="info-box-number">${{ number_format($tap->tap_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-warning"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Thread Option</span>
                                <span class="info-box-number">${{ number_format($tap->thread_option_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-ruler"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pitch Price</span>
                                <span class="info-box-number">${{ number_format($tap->pitch_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Class Price</span>
                                <span class="info-box-number">${{ number_format($tap->class_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-primary"><i class="fas fa-expand"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Size Price</span>
                                <span class="info-box-number">${{ number_format($tap->size_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <h5><i class="icon fas fa-calculator"></i> Total Potential Price:</h5>
                    <strong class="h4">
                        ${{ number_format($tap->tap_price + $tap->thread_option_price + $tap->pitch_price + $tap->class_price + $tap->size_price, 2) }}
                    </strong>
                    <p class="mb-0 mt-2">
                        <small class="text-muted">This is the maximum price if all options are selected in a quote</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-question-circle"></i> What is a Tap?
                </h3>
            </div>
            <div class="card-body">
                <p>
                    <i class="fas fa-info-circle text-info"></i> 
                    A tap is a cutting tool used to create internal threads inside a drilled hole.
                </p>
                <div class="callout callout-danger">
                    <h5><i class="fas fa-lightbulb"></i> Tapping Process:</h5>
                    <ol class="mb-0">
                        <li><strong>Drill pilot hole:</strong> Create a hole smaller than the thread diameter</li>
                        <li><strong>Select tap:</strong> Choose the correct tap for the desired thread size</li>
                        <li><strong>Cut threads:</strong> Rotate the tap to cut spiral grooves inside the hole</li>
                        <li><strong>Result:</strong> Internal threads that accept a matching bolt or screw</li>
                    </ol>
                </div>
                @if($tap->description)
                <div class="alert alert-light border mt-3">
                    <strong>Application:</strong> {{ $tap->description }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection