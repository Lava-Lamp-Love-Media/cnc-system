@extends('layouts.app')

@section('title', 'Deburs Management')
@section('page-title', 'Deburs Management')

@section('content')

<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cut"></i> Debur Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.deburs.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Debur
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
                    <th width="120">Unit Price</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deburs as $debur)
                <tr>
                    <td>{{ ($deburs->currentPage() - 1) * $deburs->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $debur->debur_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $debur->name }}</strong>
                        @if($debur->description)
                        <br><small class="text-muted">{{ Str::limit($debur->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($debur->size)
                        <strong>{{ number_format($debur->size, 2) }}mm</strong>
                        @else
                        <span class="text-muted">Variable</span>
                        @endif
                    </td>
                    <td><strong>${{ number_format($debur->unit_price, 2) }}</strong></td>
                    <td>{!! $debur->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.deburs.show', $debur->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.deburs.edit', $debur->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Debur">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.deburs.destroy', $debur->id) }}"
                            title="Delete Debur">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-cut fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No deburs found</h5>
                        <p>Click "Add Debur" to create your first debur specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($deburs->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $deburs->firstItem() ?? 0 }} to {{ $deburs->lastItem() ?? 0 }} of {{ $deburs->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $deburs->links('pagination::bootstrap-4') }}
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
    
    if (confirm('Are you sure you want to delete this debur specification?')) {
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
                alert('Error deleting debur. Please try again.');
            }
        });
    }
});
</script>
@endpush