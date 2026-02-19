@extends('layouts.app')

@section('title', 'Material Details')
@section('page-title', $material->name)

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-layer-group fa-5x text-primary mb-3"></i>
                </div>

                <h3 class="profile-username text-center">{{ $material->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $material->material_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Type</b>
                        <span class="float-right">{!! $material->type_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Unit</b>
                        <span class="float-right">{!! $material->unit_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Diameter Range</b>
                        <span class="float-right">
                            <strong>{{ number_format($material->diameter_from, 5) }}</strong>
                            → <strong>{{ number_format($material->diameter_to, 5) }}</strong>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Price</b>
                        <span class="float-right"><strong>${{ number_format($material->price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Adjustment</b>
                        <span class="float-right">
                            {{ number_format($material->adj, 2) }}
                            {!! $material->adj_type_badge !!}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Real Price</b>
                        <span class="float-right text-success"><strong>${{ number_format($material->real_price, 2) }}</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Density</b>
                        <span class="float-right"><strong>{{ number_format($material->density, 2) }} kg/m³</strong></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $material->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Sort Order</b>
                        <span class="float-right">{{ $material->sort_order }}</span>
                    </li>
                </ul>

                <a href="{{ route('company.materials.edit', $material->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Material
                </a>
                <a href="{{ route('company.materials.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Material Specification Details
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Material Code:</dt>
                    <dd class="col-sm-8"><code>{{ $material->material_code }}</code></dd>

                    <dt class="col-sm-4">Material Name:</dt>
                    <dd class="col-sm-8">{{ $material->name }}</dd>

                    <dt class="col-sm-4">Type:</dt>
                    <dd class="col-sm-8">{!! $material->type_badge !!}</dd>

                    <dt class="col-sm-4">Unit:</dt>
                    <dd class="col-sm-8">{!! $material->unit_badge !!}</dd>

                    <dt class="col-sm-4">Diameter From:</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($material->diameter_from, 5) }}</strong></dd>

                    <dt class="col-sm-4">Diameter To:</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($material->diameter_to, 5) }}</strong></dd>

                    <dt class="col-sm-4">Price (USD):</dt>
                    <dd class="col-sm-8"><strong class="text-success">${{ number_format($material->price, 2) }}</strong></dd>

                    <dt class="col-sm-4">Adjustment:</dt>
                    <dd class="col-sm-8">{{ number_format($material->adj, 2) }} &nbsp; {!! $material->adj_type_badge !!}</dd>

                    <dt class="col-sm-4">Real Price:</dt>
                    <dd class="col-sm-8"><strong class="text-success">${{ number_format($material->real_price, 2) }}</strong></dd>

                    <dt class="col-sm-4">Density (kg/m³):</dt>
                    <dd class="col-sm-8"><strong>{{ number_format($material->density, 2) }}</strong></dd>

                    @if($material->code)
                    <dt class="col-sm-4">Short Code:</dt>
                    <dd class="col-sm-8"><span class="badge badge-light border">{{ $material->code }}</span></dd>
                    @endif

                    <dt class="col-sm-4">Sort Order:</dt>
                    <dd class="col-sm-8">{{ $material->sort_order }}</dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">{!! $material->status_badge !!}</dd>

                    @if($material->notes)
                    <dt class="col-sm-4">Notes:</dt>
                    <dd class="col-sm-8">{{ $material->notes }}</dd>
                    @endif

                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $material->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $material->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calculator"></i> Usage Information
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    This material specification is used in quotes and job orders for material cost calculation.
                </p>
                <div class="callout callout-info">
                    <h5><i class="fas fa-lightbulb"></i> How Real Price is Calculated:</h5>
                    @if($material->adj_type === 'percent')
                    <p class="mb-0">
                        Real Price = Price × (1 + Adj%) =
                        ${{ number_format($material->price, 4) }} × (1 + {{ $material->adj }}%)
                        = <strong>${{ number_format($material->real_price, 4) }}</strong>
                    </p>
                    @else
                    <p class="mb-0">
                        Real Price = Price + Adj =
                        ${{ number_format($material->price, 4) }} + ${{ number_format($material->adj, 4) }}
                        = <strong>${{ number_format($material->real_price, 4) }}</strong>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection