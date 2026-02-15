@extends('layouts.app')

@section('title', 'Chamfers Management')
@section('page-title', 'Chamfers Management')

@section('content')

<div class="card card-warning card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-draw-polygon"></i> Chamfer Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.chamfers.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-plus"></i> Add Chamfer
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="120">Code</th>
                    <th>Name</th>
                    <th width="100">Size (mm)</th>
                    <th width="100">Angle (°)</th>
                    <th width="120">Unit Price</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chamfers as $chamfer)
                <tr>
                    <td>{{ ($chamfers->currentPage() - 1) * $chamfers->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $chamfer->chamfer_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $chamfer->name }}</strong>
                        @if($chamfer->description)
                        <br><small class="text-muted">{{ Str::limit($chamfer->description, 50) }}</small>
                        @endif
                    </td>
                    <td><strong>{{ number_format($chamfer->size, 2) }}mm</strong></td>
                    <td>
                        @if($chamfer->angle)
                        <strong>{{ number_format($chamfer->angle, 1) }}°</strong>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td><strong>${{ number_format($chamfer->unit_price, 2) }}</strong></td>
                    <td>{!! $chamfer->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.chamfers.show', $chamfer->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.chamfers.edit', $chamfer->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Chamfer">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.chamfers.destroy', $chamfer->id) }}"
                            title="Delete Chamfer">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-draw-polygon fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No chamfers found</h5>
                        <p>Click "Add Chamfer" to create your first chamfer specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($chamfers->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $chamfers->firstItem() ?? 0 }} to {{ $chamfers->lastItem() ?? 0 }} of {{ $chamfers->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $chamfers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    
    var deleteUrl = $(this).data('url');
    
    if (confirm('Are you sure you want to delete this chamfer specification?')) {
        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error deleting chamfer. Please try again.');
            }
        });
    }
});
</script>
@endpush