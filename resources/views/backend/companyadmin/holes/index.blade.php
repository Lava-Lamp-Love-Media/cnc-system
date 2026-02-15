@extends('layouts.app')

@section('title', 'Holes Management')
@section('page-title', 'Holes Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-circle"></i> Hole Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.holes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Hole
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
                    <th width="120">Type</th>
                    <th width="120">Unit Price</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($holes as $hole)
                <tr>
                    <td>{{ ($holes->currentPage() - 1) * $holes->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $hole->hole_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $hole->name }}</strong>
                        @if($hole->description)
                        <br><small class="text-muted">{{ Str::limit($hole->description, 50) }}</small>
                        @endif
                    </td>
                    <td><strong>Ø{{ number_format($hole->size, 2) }}</strong></td>
                    <td>{!! $hole->type_badge !!}</td>
                    <td><strong>${{ number_format($hole->unit_price, 2) }}</strong></td>
                    <td>{!! $hole->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.holes.show', $hole->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.holes.edit', $hole->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Hole">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.holes.destroy', $hole->id) }}"
                            title="Delete Hole">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-circle fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No holes found</h5>
                        <p>Click "Add Hole" to create your first hole specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($holes->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $holes->firstItem() ?? 0 }} to {{ $holes->lastItem() ?? 0 }} of {{ $holes->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $holes->links('pagination::bootstrap-4') }}
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
    
    if (confirm('Are you sure you want to delete this hole specification?')) {
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
                alert('Error deleting hole. Please try again.');
            }
        });
    }
});
</script>
@endpush