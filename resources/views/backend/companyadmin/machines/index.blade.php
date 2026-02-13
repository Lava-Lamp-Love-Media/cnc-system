@extends('layouts.app')

@section('title', 'Machines')
@section('page-title', 'Machine Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-industry"></i> Machine List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.machines.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Machine
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Machine Code</th>
                    <th>Name</th>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Location</th>
                    <th width="120">Status</th>
                    <th width="100">Hours</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($machines as $machine)
                <tr>
                    <td>{{ ($machines->currentPage() - 1) * $machines->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $machine->machine_code }}</code>
                        </span>
                    </td>
                    <td>
                        <i class="fas fa-cog text-primary mr-2"></i>
                        <strong>{{ $machine->name }}</strong>
                    </td>
                    <td>{{ $machine->manufacturer ?? '—' }}</td>
                    <td>{{ $machine->model ?? '—' }}</td>
                    <td>
                        @if($machine->location)
                        <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                        {{ $machine->location }}
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $machine->status_badge !!}</td>
                    <td>
                        <span class="badge badge-info px-2 py-1">
                            {{ number_format($machine->operating_hours) }} hrs
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('company.machines.show', $machine->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.machines.edit', $machine->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Machine">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.machines.destroy', $machine->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Machine">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No machines found</h5>
                        <p>Click "Add Machine" to register your first machine.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($machines->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $machines->firstItem() ?? 0 }} to {{ $machines->lastItem() ?? 0 }} of {{ $machines->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $machines->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection