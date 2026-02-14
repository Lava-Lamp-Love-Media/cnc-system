@extends('layouts.app')

@section('title', 'Customers')
@section('page-title', 'Customer Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Customer List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.customers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Customer
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Code</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th width="100">Type</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $customer->customer_code }}</code>
                        </span>
                    </td>
                    <td>
                        @if($customer->logo)
                        <img src="{{ $customer->logo_url }}"
                            alt="{{ $customer->name }}"
                            class="img-circle elevation-1 mr-2"
                            style="width: 35px; height: 35px; object-fit: cover;">
                        @else
                        <img src="{{ $customer->logo_url }}"
                            alt="{{ $customer->name }}"
                            class="img-circle elevation-1 mr-2"
                            style="width: 35px; height: 35px;">
                        @endif
                        <strong>{{ $customer->name }}</strong>
                    </td>
                    <td>
                        @if($customer->email)
                        <i class="fas fa-envelope text-muted fa-xs mr-1"></i>
                        <small>{{ $customer->email }}</small><br>
                        @endif
                        @if($customer->phone)
                        <i class="fas fa-phone text-muted fa-xs mr-1"></i>
                        <small>{{ $customer->phone }}</small>
                        @endif
                        @if(!$customer->email && !$customer->phone)
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($customer->billingAddress)
                        <i class="fas fa-map-marker-alt text-muted fa-xs mr-1"></i>
                        <small>{{ $customer->billingAddress->city }}{{ $customer->billingAddress->state ? ', ' . $customer->billingAddress->state : '' }}</small>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $customer->type_badge !!}</td>
                    <td>{!! $customer->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.customers.show', $customer->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.customers.edit', $customer->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Customer">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.customers.destroy', $customer->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Customer">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No customers found</h5>
                        <p>Click "Add Customer" to register your first customer.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $customers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection