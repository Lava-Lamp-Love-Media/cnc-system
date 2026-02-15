@extends('layouts.app')

@section('title', 'Threads Management')
@section('page-title', 'Threads Management')

@section('content')

<div class="card card-purple card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-spinner"></i> Thread Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.threads.create') }}" class="btn btn-purple btn-sm" style="background-color: #6f42c1; border-color: #6f42c1; color: white;">
                <i class="fas fa-plus"></i> Add Thread
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
                    <th width="100">Type</th>
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
                @forelse($threads as $thread)
                <tr>
                    <td>{{ ($threads->currentPage() - 1) * $threads->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $thread->thread_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $thread->name }}</strong>
                        @if($thread->description)
                        <br><small class="text-muted">{{ Str::limit($thread->description, 40) }}</small>
                        @endif
                    </td>
                    <td>{!! $thread->type_badge !!}</td>
                    <td>
                        <strong>Ø{{ number_format($thread->diameter, 2) }}mm</strong><br>
                        <small class="text-muted">{{ number_format($thread->pitch, 2) }}mm pitch</small>
                    </td>
                    <td>{!! $thread->standard_badge !!}</td>
                    <td>
                        @if($thread->thread_class)
                        <span class="badge badge-secondary">{{ $thread->thread_class }}</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $thread->direction_badge !!}</td>
                    <td><strong>${{ number_format($thread->thread_price, 2) }}</strong></td>
                    <td>{!! $thread->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.threads.show', $thread->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.threads.edit', $thread->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Thread">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.threads.destroy', $thread->id) }}"
                            title="Delete Thread">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted py-5">
                        <i class="fas fa-spinner fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No threads found</h5>
                        <p>Click "Add Thread" to create your first thread specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($threads->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $threads->firstItem() ?? 0 }} to {{ $threads->lastItem() ?? 0 }} of {{ $threads->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $threads->links('pagination::bootstrap-4') }}
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
    
    if (confirm('Are you sure you want to delete this thread specification?')) {
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
                alert('Error deleting thread. Please try again.');
            }
        });
    }
});
</script>
@endpush