@extends('layouts.app')

@section('title', 'Plans')
@section('page-title', 'Plan Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-crown"></i> Plan List
        </h3>

        <div class="card-tools">
            <a href="{{ route('superadmin.plans.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Plan
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Name</th>
                    <th width="120">Price</th>
                    <th width="120">Duration</th>
                    <th>Features</th>
                    <th width="100">Status</th>
                    <th width="120" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ ($plans->currentPage() - 1) * $plans->perPage() + $loop->iteration }}</td>
                    <td>
                        <i class="fas fa-crown text-warning mr-2"></i>
                        <strong>{{ $plan->name }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-success px-2 py-1">
                            ${{ number_format($plan->price, 2) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info px-2 py-1">
                            {{ $plan->duration_days }} days
                        </span>
                    </td>
                    <td>
                        @forelse($plan->features as $feature)
                        <span class="badge badge-light border mr-1 mb-1">
                            <i class="fas fa-cube fa-xs"></i> {{ $feature->name }}
                        </span>
                        @empty
                        <span class="text-muted">No features</span>
                        @endforelse
                    </td>
                    <td>
                        @if($plan->is_active)
                        <span class="badge badge-success px-2 py-1">
                            <i class="fas fa-check-circle"></i> Active
                        </span>
                        @else
                        <span class="badge badge-secondary px-2 py-1">
                            <i class="fas fa-times-circle"></i> Inactive
                        </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('superadmin.plans.edit', $plan->id) }}"
                            class="btn btn-warning btn-sm mr-1"
                            title="Edit Plan">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('superadmin.plans.destroy', $plan->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm btn-delete"
                                title="Delete Plan">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No plans found</h5>
                        <p>Click "Add Plan" to create your first plan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($plans->hasPages())
    <div class="card-footer clearfix">
        <div class="float-left">
            <p class="text-muted mb-0">
                Showing {{ $plans->firstItem() }} to {{ $plans->lastItem() }} of {{ $plans->total() }} entries
            </p>
        </div>
        <div class="float-right">
            {{ $plans->links() }}
        </div>
    </div>
    @endif
</div>

@endsection