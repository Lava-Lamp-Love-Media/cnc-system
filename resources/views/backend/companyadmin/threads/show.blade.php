@extends('layouts.app')

@section('title', 'Thread Details')
@section('page-title', $thread->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card" style="border-top: 3px solid #6f42c1;">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-spinner fa-5x mb-3" style="color: #6f42c1;"></i>
                </div>

                <h3 class="profile-username text-center">{{ $thread->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $thread->thread_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Type</b>
                        <span class="float-right">{!! $thread->type_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Thread Spec</b>
                        <span class="float-right">
                            <strong>{{ $thread->thread_spec }}</strong>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Standard</b>
                        <span class="float-right">{!! $thread->standard_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Thread Class</b>
                        <span class="float-right">
                            @if($thread->thread_class)
                            <span class="badge badge-secondary">{{ $thread->thread_class }}</span>
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Direction</b>
                        <span class="float-right">{!! $thread->direction_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Thread Price</b>
                        <span class="float-right"><strong>${{ number_format($thread->thread_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $thread->status_badge !!}</span>
                    </li>
                </ul>

                <a href="{{ route('company.threads.edit', $thread->id) }}" class="btn btn-block" style="background-color: #6f42c1; border-color: #6f42c1; color: white;">
                    <i class="fas fa-edit"></i> Edit Thread
                </a>
                <a href="{{ route('company.threads.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card" style="border-top: 3px solid #6f42c1;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Thread Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Thread Code:</dt>
                    <dd class="col-sm-8"><code>{{ $thread->thread_code }}</code></dd>

                    <dt class="col-sm-4">Thread Name:</dt>
                    <dd class="col-sm-8">{{ $thread->name }}</dd>

                    <dt class="col-sm-4">Thread Type:</dt>
                    <dd class="col-sm-8">{!! $thread->type_badge !!}</dd>

                    <dt class="col-sm-4">Diameter:</dt>
                    <dd class="col-sm-8"><strong>Ø{{ number_format($thread->diameter, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Pitch:</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($thread->pitch, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Thread Standard:</dt>
                    <dd class="col-sm-8">{!! $thread->standard_badge !!}</dd>

                    <dt class="col-sm-4">Thread Class:</dt>
                    <dd class="col-sm-8">
                        @if($thread->thread_class)
                        <span class="badge badge-secondary">{{ $thread->thread_class }}</span>
                        @else
                        <span class="text-muted">Not specified</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Direction:</dt>
                    <dd class="col-sm-8">{!! $thread->direction_badge !!}</dd>

                    @if($thread->thread_sizes && count($thread->thread_sizes) > 0)
                    <dt class="col-sm-4">Thread Sizes:</dt>
                    <dd class="col-sm-8">
                        @foreach($thread->thread_sizes as $size)
                        <span class="badge badge-info mr-1">{{ $size }}</span>
                        @endforeach
                    </dd>
                    @endif

                    @if($thread->thread_options && count($thread->thread_options) > 0)
                    <dt class="col-sm-4">Thread Options:</dt>
                    <dd class="col-sm-8">
                        @foreach($thread->thread_options as $option)
                        <span class="badge badge-primary mr-1">{{ ucfirst($option) }}</span>
                        @endforeach
                    </dd>
                    @endif

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $thread->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $thread->status_badge !!}</dd>

                    @if($thread->description)
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $thread->description }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $thread->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $thread->updated_at->format('M d, Y h:i A') }}</dd>
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
                            <span class="info-box-icon" style="background-color: #6f42c1;"><i class="fas fa-spinner"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Thread Price</span>
                                <span class="info-box-number">${{ number_format($thread->thread_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-warning"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Option Price</span>
                                <span class="info-box-number">${{ number_format($thread->option_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-ruler"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pitch Price</span>
                                <span class="info-box-number">${{ number_format($thread->pitch_price, 2) }}</span>
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
                                <span class="info-box-number">${{ number_format($thread->class_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-primary"><i class="fas fa-expand"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Size Price</span>
                                <span class="info-box-number">${{ number_format($thread->size_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <h5><i class="icon fas fa-calculator"></i> Total Potential Price:</h5>
                    <strong class="h4">
                        ${{ number_format($thread->thread_price + $thread->option_price + $thread->pitch_price + $thread->class_price + $thread->size_price, 2) }}
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
                    <i class="fas fa-question-circle"></i> What is Threading?
                </h3>
            </div>
            <div class="card-body">
                <p>
                    <i class="fas fa-info-circle text-info"></i> 
                    Threading is the process of creating helical ridges on a cylindrical surface.
                </p>
                <div class="callout" style="border-left-color: #6f42c1;">
                    <h5><i class="fas fa-lightbulb"></i> Thread Types:</h5>
                    <ul class="mb-0">
                        <li><strong>External Threads ({{ $thread->thread_type === 'external' ? '✓ This Type' : '' }}):</strong> Created on the outside of cylindrical parts like bolts and screws</li>
                        <li><strong>Internal Threads ({{ $thread->thread_type === 'internal' ? '✓ This Type' : '' }}):</strong> Created inside holes using taps to accept bolts</li>
                    </ul>
                </div>
                @if($thread->description)
                <div class="alert alert-light border mt-3">
                    <strong>Application:</strong> {{ $thread->description }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection