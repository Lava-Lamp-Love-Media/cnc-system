@extends('layouts.app')

@section('title', 'Warehouses')
@section('page-title', 'Warehouse Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-warehouse"></i> Warehouse List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.warehouses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Warehouse
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Code</th>
                    <th>Warehouse Name</th>
                    <th>Location</th>
                    <th width="120">Type</th>
                    <th width="120">Capacity</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $warehouse)
                <tr>
                    <td>{{ ($warehouses->currentPage() - 1) * $warehouses->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $warehouse->warehouse_code }}</code>
                        </span>
                    </td>
                    <td>
                        <i class="fas fa-warehouse text-primary mr-2"></i>
                        <strong>{{ $warehouse->name }}</strong>
                        @if($warehouse->manager_name)
                        <br><small class="text-muted">
                            <i class="fas fa-user fa-xs"></i> {{ $warehouse->manager_name }}
                        </small>
                        @endif
                    </td>
                    <td>
                        @if($warehouse->city || $warehouse->state)
                        <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                        {{ $warehouse->city }}{{ $warehouse->city && $warehouse->state ? ', ' : '' }}{{ $warehouse->state }}
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $warehouse->type_badge !!}</td>
                    <td>
                        @if($warehouse->storage_capacity)
                        <span class="badge badge-info px-2 py-1">
                            {{ number_format($warehouse->storage_capacity) }} {{ strtoupper($warehouse->capacity_unit) }}
                        </span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $warehouse->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.warehouses.show', $warehouse->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.warehouses.edit', $warehouse->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Warehouse">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.warehouses.destroy', $warehouse->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Warehouse">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No warehouses found</h5>
                        <p>Click "Add Warehouse" to register your first warehouse.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($warehouses->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $warehouses->firstItem() ?? 0 }} to {{ $warehouses->lastItem() ?? 0 }} of {{ $warehouses->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $warehouses->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection