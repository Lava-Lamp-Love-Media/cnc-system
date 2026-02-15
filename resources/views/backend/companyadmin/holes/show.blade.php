@extends('layouts.app')

@section('title', 'Hole Details')
@section('page-title', $hole->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-circle fa-5x text-primary mb-3"></i>
                </div>

                <h3 class="profile-username text-center">{{ $hole->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $hole->hole_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Size</b>
                        <span class="float-right"><strong>Ø{{ number_format($hole->size, 3) }}mm</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Type</b>
                        <span class="float-right">{!! $hole->type_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Unit Price</b>
                        <span class="float-right"><strong>${{ number_format($hole->unit_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $hole->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Sort Order</b>
                        <span class="float-right">{{ $hole->sort_order }}</span>
                    </li>
                </ul>

                <a href="{{ route('company.holes.edit', $hole->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Hole
                </a>
                <a href="{{ route('company.holes.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Hole Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Hole Code:</dt>
                    <dd class="col-sm-8"><code>{{ $hole->hole_code }}</code></dd>

                    <dt class="col-sm-4">Hole Name:</dt>
                    <dd class="col-sm-8">{{ $hole->name }}</dd>

                    <dt class="col-sm-4">Size (Diameter):</dt>
                    <dd class="col-sm-8"><strong>Ø{{ number_format($hole->size, 3) }}mm</strong></dd>

                    <dt class="col-sm-4">Hole Type:</dt>
                    <dd class="col-sm-8">{!! $hole->type_badge !!}</dd>

                    <dt class="col-sm-4">Unit Price:</dt>
                    <dd class="col-sm-8"><strong class="text-success">${{ number_format($hole->unit_price, 2) }}</strong></dd>

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $hole->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $hole->status_badge !!}</dd>

                    @if($hole->description)
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $hole->description }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $hole->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $hole->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i> Usage Information
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    This hole specification can be used in quotes and job orders.
                </p>
                <div class="callout callout-info">
                    <h5><i class="fas fa-lightbulb"></i> Typical Use Case:</h5>
                    <p class="mb-0">{{ $hole->description ?: 'Standard drilling operation for manufacturing processes.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection