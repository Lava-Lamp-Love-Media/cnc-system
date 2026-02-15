@extends('layouts.app')

@section('title', 'Chamfer Details')
@section('page-title', $chamfer->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card card-warning card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-draw-polygon fa-5x text-warning mb-3"></i>
                </div>

                <h3 class="profile-username text-center">{{ $chamfer->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $chamfer->chamfer_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Size</b>
                        <span class="float-right"><strong>{{ number_format($chamfer->size, 3) }}mm</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Angle</b>
                        <span class="float-right">
                            @if($chamfer->angle)
                            <strong>{{ number_format($chamfer->angle, 1) }}°</strong>
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Unit Price</b>
                        <span class="float-right"><strong>${{ number_format($chamfer->unit_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $chamfer->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Sort Order</b>
                        <span class="float-right">{{ $chamfer->sort_order }}</span>
                    </li>
                </ul>

                <a href="{{ route('company.chamfers.edit', $chamfer->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Chamfer
                </a>
                <a href="{{ route('company.chamfers.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Chamfer Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Chamfer Code:</dt>
                    <dd class="col-sm-8"><code>{{ $chamfer->chamfer_code }}</code></dd>

                    <dt class="col-sm-4">Chamfer Name:</dt>
                    <dd class="col-sm-8">{{ $chamfer->name }}</dd>

                    <dt class="col-sm-4">Size (Width):</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($chamfer->size, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Angle:</dt>
                    <dd class="col-sm-8">
                        @if($chamfer->angle)
                        <strong>{{ number_format($chamfer->angle, 1) }}°</strong>
                        @else
                        <span class="text-muted">Not specified (edge break)</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Full Specification:</dt>
                    <dd class="col-sm-8">
                        <strong class="text-primary">{{ $chamfer->formatted_size }}</strong>
                    </dd>

                    <dt class="col-sm-4">Unit Price:</dt>
                    <dd class="col-sm-8"><strong class="text-success">${{ number_format($chamfer->unit_price, 2) }}</strong></dd>

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $chamfer->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $chamfer->status_badge !!}</dd>

                    @if($chamfer->description)
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $chamfer->description }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $chamfer->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $chamfer->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-question-circle"></i> What is a Chamfer?
                </h3>
            </div>
            <div class="card-body">
                <p>
                    <i class="fas fa-info-circle text-info"></i> 
                    A chamfer is an angled cut that creates a beveled edge on a hole or surface.
                </p>
                <div class="callout callout-warning">
                    <h5><i class="fas fa-lightbulb"></i> Purpose:</h5>
                    <ul class="mb-0">
                        <li>Guides bolts and screws into holes smoothly</li>
                        <li>Removes sharp edges for safety</li>
                        <li>Prevents stress concentration at corners</li>
                        <li>Professional, finished appearance</li>
                    </ul>
                </div>
                @if($chamfer->description)
                <div class="alert alert-light border mt-3">
                    <strong>Application:</strong> {{ $chamfer->description }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection