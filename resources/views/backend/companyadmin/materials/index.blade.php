@extends('layouts.app')

@section('title', 'Materials Management')
@section('page-title', 'Materials Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Material Specifications
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.materials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Material
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="130">Code</th>
                    <th>Name</th>
                    <th width="110">Type</th>
                    <th width="60">Unit</th>
                    <th width="110">Diameter From</th>
                    <th width="110">Diameter To</th>
                    <th width="110">Price (USD)</th>
                    <th width="70">Adj</th>
                    <th width="90">Adj Type</th>
                    <th width="100">Real Price</th>
                    <th width="120">Density (kg/m³)</th>
                    <th width="60">Code</th>
                    <th width="90">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr>
                    <td>{{ ($materials->currentPage() - 1) * $materials->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $material->material_code }}</code>
                        </span>
                    </td>
                    <td>
                        <strong>{{ $material->name }}</strong>
                        @if($material->notes)
                        <br><small class="text-muted">{{ Str::limit($material->notes, 50) }}</small>
                        @endif
                    </td>
                    <td>{!! $material->type_badge !!}</td>
                    <td>{!! $material->unit_badge !!}</td>
                    <td><strong>{{ number_format($material->diameter_from, 5) }}</strong></td>
                    <td><strong>{{ number_format($material->diameter_to,   5) }}</strong></td>
                    <td><strong class="text-success">${{ number_format($material->price, 2) }}</strong></td>
                    <td>{{ number_format($material->adj, 2) }}</td>
                    <td>{!! $material->adj_type_badge !!}</td>
                    <td><strong>${{ number_format($material->real_price, 2) }}</strong></td>
                    <td>{{ number_format($material->density, 2) }}</td>
                    <td>
                        @if($material->code)
                            <span class="badge badge-light border">{{ $material->code }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $material->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.materials.show', $material->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.materials.edit', $material->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Material">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-xs delete-btn"
                            data-url="{{ route('company.materials.destroy', $material->id) }}"
                            title="Delete Material">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="15" class="text-center text-muted py-5">
                        <i class="fas fa-layer-group fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No materials found</h5>
                        <p>Click "Add Material" to create your first material specification.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($materials->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $materials->firstItem() ?? 0 }} to {{ $materials->lastItem() ?? 0 }} of {{ $materials->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $materials->links('pagination::bootstrap-4') }}
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

    if (confirm('Are you sure you want to delete this material specification?')) {
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
                alert('Error deleting material. Please try again.');
            }
        });
    }
});
</script>
@endpush