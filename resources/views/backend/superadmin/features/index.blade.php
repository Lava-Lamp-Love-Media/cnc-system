@extends('layouts.app')

@section('title', 'Features')
@section('page-title', 'Feature Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Feature List
        </h3>

        <div class="card-tools">
            <a href="{{ route('superadmin.features.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Feature
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th width="120">Status</th>
                    <th width="120" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                <tr>
                    <td>{{ ($features->currentPage() - 1) * $features->perPage() + $loop->iteration }}</td>
                    <td>
                        <i class="fas fa-cube text-primary mr-2"></i>
                        <strong>{{ $feature->name }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $feature->slug }}</code>
                        </span>
                    </td>
                    <td>
                        @if($feature->is_active)
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
                        <a href="{{ route('superadmin.features.edit', $feature->id) }}"
                            class="btn btn-warning btn-sm mr-1"
                            title="Edit Feature">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('superadmin.features.destroy', $feature->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm btn-delete"
                                title="Delete Feature">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No features found</h5>
                        <p>Click "Add Feature" to create your first feature.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($features->hasPages())
    <div class="card-footer clearfix">
        <div class="float-left">
            <p class="text-muted mb-0">
                Showing {{ $features->firstItem() }} to {{ $features->lastItem() }} of {{ $features->total() }} entries
            </p>
        </div>
        <div class="float-right">
            {{ $features->links() }}
        </div>
    </div>
    @endif
</div>

@endsection