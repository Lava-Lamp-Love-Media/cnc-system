@extends('layouts.app')

@section('title', 'Operators')
@section('page-title', 'Operator Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-hard-hat"></i> Operator List
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.operators.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Operator
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
                    <th>Contact</th>
                    <th width="120">Skill Level</th>
                    <th width="100">Status</th>
                    <th width="140" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operators as $operator)
                <tr>
                    <td>{{ ($operators->currentPage() - 1) * $operators->perPage() + $loop->iteration }}</td>
                    <td>
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $operator->operator_code }}</code>
                        </span>
                    </td>
                    <td>
                        <i class="fas fa-user text-primary mr-2"></i>
                        <strong>{{ $operator->name }}</strong>
                    </td>
                    <td>
                        @if($operator->email)
                        <i class="fas fa-envelope text-muted mr-1"></i>
                        {{ $operator->email }}<br>
                        @endif
                        @if($operator->phone)
                        <i class="fas fa-phone text-muted mr-1"></i>
                        {{ $operator->phone }}
                        @endif
                        @if(!$operator->email && !$operator->phone)
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{!! $operator->skill_badge !!}</td>
                    <td>{!! $operator->status_badge !!}</td>
                    <td class="text-center">
                        <a href="{{ route('company.operators.show', $operator->id) }}"
                            class="btn btn-info btn-xs mr-1"
                            title="View Details">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                        <a href="{{ route('company.operators.edit', $operator->id) }}"
                            class="btn btn-warning btn-xs mr-1"
                            title="Edit Operator">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('company.operators.destroy', $operator->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-xs btn-delete"
                                title="Delete Operator">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No operators found</h5>
                        <p>Click "Add Operator" to register your first operator.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($operators->hasPages())
    <div class="card-footer clearfix">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Showing {{ $operators->firstItem() ?? 0 }} to {{ $operators->lastItem() ?? 0 }} of {{ $operators->total() }} entries
                </p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $operators->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection