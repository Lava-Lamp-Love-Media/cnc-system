@extends('layouts.app')

@section('title', 'Debur Details')
@section('page-title', $debur->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-cut fa-5x text-success mb-3"></i>
                </div>

                <h3 class="profile-username text-center">{{ $debur->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $debur->debur_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Size</b>
                        <span class="float-right">
                            @if($debur->size)
                            <strong>{{ number_format($debur->size, 3) }}mm</strong>
                            @else
                            <span class="text-muted">Variable</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Unit Price</b>
                        <span class="float-right"><strong>${{ number_format($debur->unit_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $debur->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Sort Order</b>
                        <span class="float-right">{{ $debur->sort_order }}</span>
                    </li>
                </ul>

                <a href="{{ route('company.deburs.edit', $debur->id) }}" class="btn btn-success btn-block">
                    <i class="fas fa-edit"></i> Edit Debur
                </a>
                <a href="{{ route('company.deburs.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Debur Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Debur Code:</dt>
                    <dd class="col-sm-8"><code>{{ $debur->debur_code }}</code></dd>

                    <dt class="col-sm-4">Debur Name:</dt>
                    <dd class="col-sm-8">{{ $debur->name }}</dd>

                    <dt class="col-sm-4">Size (Material Removal):</dt>
                    <dd class="col-sm-8">
                        @if($debur->size)
                        <strong>{{ number_format($debur->size, 3) }}mm</strong>
                        @else
                        <span class="text-muted">Variable / Not specified</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Unit Price:</dt>
                    <dd class="col-sm-8"><strong class="text-success">${{ number_format($debur->unit_price, 2) }}</strong></dd>

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $debur->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $debur->status_badge !!}</dd>

                    @if($debur->description)
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $debur->description }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $debur->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $debur->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-question-circle"></i> What is Deburring?
                </h3>
            </div>
            <div class="card-body">
                <p>
                    <i class="fas fa-info-circle text-info"></i> 
                    Deburring removes rough edges (burrs) left after drilling, milling, or machining operations.
                </p>
                <div class="callout callout-success">
                    <h5><i class="fas fa-lightbulb"></i> Purpose:</h5>
                    <ul class="mb-0">
                        <li><strong>Safety:</strong> Prevents cuts and injuries from sharp edges</li>
                        <li><strong>Quality:</strong> Improves part fit and assembly</li>
                        <li><strong>Finish:</strong> Better surface finish and appearance</li>
                        <li><strong>Reliability:</strong> Removes metal whiskers that could break off</li>
                    </ul>
                </div>
                @if($debur->description)
                <div class="alert alert-light border mt-3">
                    <strong>Application:</strong> {{ $debur->description }}
                </div>
                @endif
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Debur Size</span>
                                <span class="info-box-number">{{ $debur->formatted_size }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-warning"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Unit Price</span>
                                <span class="info-box-number">${{ number_format($debur->unit_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection