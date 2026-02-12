@extends('layouts.app')

@section('title','Companies')
@section('page-title','Company Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-building"></i> Company List
        </h3>

        <div class="card-tools">
            <a href="{{ route('superadmin.companies.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Company
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th width="120">Plan</th>
                    <th width="120">Status</th>
                    <th width="150">Subscription</th>
                    <th width="120" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr>
                    <td>{{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}</td>
                    <td>
                        <i class="fas fa-building text-primary mr-2"></i>
                        <strong>{{ $company->name }}</strong>
                    </td>
                    <td>
                        <i class="fas fa-envelope text-muted mr-1"></i>
                        {{ $company->email }}
                    </td>
                    <td>
                        @if($company->phone)
                        <i class="fas fa-phone text-muted mr-1"></i>
                        {{ $company->phone }}
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($company->plan)
                        <span class="badge badge-primary px-2 py-1">
                            <i class="fas fa-crown fa-xs"></i> {{ $company->plan->name }}
                        </span>
                        @else
                        <span class="badge badge-secondary px-2 py-1">No Plan</span>
                        @endif
                    </td>
                    <td>
                        @if($company->status === 'active')
                        <span class="badge badge-success px-2 py-1">
                            <i class="fas fa-check-circle"></i> Active
                        </span>
                        @elseif($company->status === 'trial')
                        <span class="badge badge-warning px-2 py-1">
                            <i class="fas fa-clock"></i> Trial
                        </span>
                        @elseif($company->status === 'suspended')
                        <span class="badge badge-danger px-2 py-1">
                            <i class="fas fa-ban"></i> Suspended
                        </span>
                        @else
                        <span class="badge badge-secondary px-2 py-1">{{ ucfirst($company->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($company->subscription_start && $company->subscription_end)
                        <small class="text-muted">
                            <i class="far fa-calendar-alt"></i>
                            {{ $company->subscription_end->format('M d, Y') }}
                            @if($company->subscription_end->isFuture())
                            <br><span class="badge badge-info badge-sm mt-1">{{ $company->subscription_end->diffInDays(now()) }} days left</span>
                            @else
                            <br><span class="badge badge-danger badge-sm mt-1">Expired</span>
                            @endif
                        </small>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('superadmin.companies.edit', $company->id) }}"
                            class="btn btn-warning btn-sm mr-1"
                            title="Edit Company">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('superadmin.companies.destroy', $company->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm btn-delete"
                                title="Delete Company">
                                <i class="fas fa-trash-alt "></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No companies found</h5>
                        <p>Click "Add Company" to create your first company.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($companies->hasPages())
    <div class="card-footer clearfix">
        <div class="float-left">
            <p class="text-muted mb-0">
                Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }} entries
            </p>
        </div>
        <div class="float-right">
            {{ $companies->links() }}
        </div>
    </div>
    @endif
</div>

@endsection