@extends('layouts.app')

@section('title', 'Taps Management')
@section('page-title', 'Taps Management')

@section('content')

<div class="card card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-screwdriver"></i> Tap Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.taps.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus"></i> Add Tap
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th width="120">Code</th>
                    <th>Name</th>
                    <th width="120">Thread Spec</th>
                    <th width="100">Standard</th>
                    <th width="80">Class</th>
                    <th width="100">Direction</th>
                    <th width="100">Price</th>
                    <th width="80">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($taps as $tap)
                <tr>
                    <td>{{ ($taps->currentPage() - 1) * $taps->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $tap->tap_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $tap->name }}</strong>
                        @if($tap->description)
                        <br><small class="text-muted">{{ Str::limit($tap->description, 40) }}</small>
                        @endif
                    </td>
                    <td>
                        <strong>Ø{{ number_format($tap->diameter, 2) }}mm</strong><br>
                        <small class="text-muted">{{ number_format($tap->pitch, 2) }}mm pitch</small>
                    </td>
                    <td>{!! $tap->standard_badge !!}</td>
                    <td>
                        @if($tap->thread_class)
                        <span class="badge badge-secondary">{{ $tap->thread_class }}</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $tap->direction_badge !!}</td>
                    <td><strong>${{ number_format($tap->tap_price, 2) }}</strong></td>
                    <td>{!! $tap->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.taps.show', $tap->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.taps.edit', $tap->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Tap">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.taps.destroy', $tap->id) }}"
                            title="Delete Tap">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-5">
                        <i class="fas fa-screwdriver fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No taps found</h5>
                        <p>Click "Add Tap" to create your first tap specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($taps->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $taps->firstItem() ?? 0 }} to {{ $taps->lastItem() ?? 0 }} of {{ $taps->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $taps->links('pagination::bootstrap-4') }}
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
    
    if (confirm('Are you sure you want to delete this tap specification?')) {
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
                alert('Error deleting tap. Please try again.');
            }
        });
    }
});
</script>
@endpush