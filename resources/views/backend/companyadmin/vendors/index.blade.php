@extends('layouts.app')

@section('title', 'Vendors')
@section('page-title', 'Vendor Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-truck"></i> Vendor List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.vendors.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Vendor
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Code</th>
                    <th>Vendor Name</th>
                    <th>Contact</th>
                    <th width="120">Type</th>
                    <th width="100">Lead Time</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td>{{ ($vendors->currentPage() - 1) * $vendors->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $vendor->vendor_code }}</code>
                        </span>
                    </td>
                    <td>
                        @if($vendor->logo)
                        <img src="{{ $vendor->logo_url }}" 
                             alt="{{ $vendor->name }}" 
                             class="img-circle elevation-1 mr-2"
                             style="width: 35px; height: 35px; object-fit: cover;">
                        @else
                        <img src="{{ $vendor->logo_url }}" 
                             alt="{{ $vendor->name }}" 
                             class="img-circle elevation-1 mr-2"
                             style="width: 35px; height: 35px;">
                        @endif
                        <strong>{{ $vendor->name }}</strong>
                    </td>
                    <td>
                        @if($vendor->email)
                        <i class="fas fa-envelope text-muted fa-xs mr-1"></i>
                        <small>{{ $vendor->email }}</small><br>
                        @endif
                        @if($vendor->phone)
                        <i class="fas fa-phone text-muted fa-xs mr-1"></i>
                        <small>{{ $vendor->phone }}</small>
                        @endif
                        @if(!$vendor->email && !$vendor->phone)
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $vendor->type_badge !!}</td>
                    <td>
                        @if($vendor->lead_time_days)
                        <span class="badge badge-info">{{ $vendor->lead_time_days }} days</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $vendor->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.vendors.show', $vendor->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.vendors.edit', $vendor->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Vendor">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.vendors.destroy', $vendor->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Vendor">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No vendors found</h5>
                        <p>Click "Add Vendor" to register your first vendor.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vendors->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $vendors->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection