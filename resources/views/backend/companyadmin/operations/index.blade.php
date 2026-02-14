@extends('layouts.app')

@section('title', 'Operations')
@section('page-title', 'Operation Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tools"></i> Operation List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.operations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Operation
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Code</th>
                    <th>Operation Name</th>
                    <th>Description</th>
                    <th width="120">Hourly Rate</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operations as $operation)
                <tr>
                    <td>{{ ($operations->currentPage() - 1) * $operations->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $operation->operation_code }}</code>
                        </span>
                    </td>
                    <td>
                        <i class="fas fa-cogs text-primary mr-2"></i>
                        <strong>{{ $operation->name }}</strong>
                    </td>
                    <td>
                        @if($operation->description)
                        <small class="text-muted">{{ Str::limit($operation->description, 50) }}</small>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($operation->hourly_rate)
                        <span class="badge badge-success px-2 py-1">
                            ${{ number_format($operation->hourly_rate, 2) }}/hr
                        </span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $operation->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.operations.show', $operation->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.operations.edit', $operation->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Operation">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.operations.destroy', $operation->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Operation">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No operations found</h5>
                        <p>Click "Add Operation" to create your first operation type.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($operations->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $operations->firstItem() ?? 0 }} to {{ $operations->lastItem() ?? 0 }} of {{ $operations->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $operations->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection