@extends('layouts.app')

@section('title','Trial Requests')
@section('page-title','Trial Requests')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-inbox"></i> Trial Requests
        </h3>

        <div class="card-tools">
            <span class="badge badge-warning">
                {{ \App\Models\TrialRequest::where('status', 'pending')->count() }} Pending
            </span>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Company</th>
                    <th>Contact Person</th>
                    <th width="120">Preferred Plan</th>
                    <th width="100">Status</th>
                    <th width="120">Requested</th>
                    <th width="200" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $r)
                <tr class="{{ $r->status === 'pending' ? 'table-warning' : '' }}">
                    <td>{{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}</td>
                    <td>
                        <i class="fas fa-building text-primary mr-2"></i>
                        <strong>{{ $r->company_name }}</strong><br>
                        <small class="text-muted">
                            <i class="fas fa-envelope fa-xs"></i> {{ $r->company_email }}
                        </small>
                        @if($r->phone)
                        <br><small class="text-muted">
                            <i class="fas fa-phone fa-xs"></i> {{ $r->phone }}
                        </small>
                        @endif
                    </td>
                    <td>
                        <i class="fas fa-user text-info mr-2"></i>
                        {{ $r->contact_name }}<br>
                        <small class="text-muted">{{ $r->contact_email }}</small>
                    </td>
                    <td>
                        @if($r->preferred_plan_slug)
                        <span class="badge badge-light border">
                            <code class="text-dark">{{ $r->preferred_plan_slug }}</code>
                        </span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($r->status === 'pending')
                        <span class="badge badge-warning px-2 py-1">
                            <i class="fas fa-clock"></i> Pending
                        </span>
                        @elseif($r->status === 'approved')
                        <span class="badge badge-success px-2 py-1">
                            <i class="fas fa-check-circle"></i> Approved
                        </span>
                        @else
                        <span class="badge badge-danger px-2 py-1">
                            <i class="fas fa-times-circle"></i> Rejected
                        </span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="far fa-calendar-alt"></i>
                            {{ $r->created_at->format('M d, Y') }}
                            <br>{{ $r->created_at->format('h:i A') }}
                        </small>
                    </td>
                    <td class="text-center">
                        @if($r->status === 'pending')
                        <form method="POST" action="{{ route('superadmin.trial_requests.approve', $r->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-xs mr-1" title="Approve Request">
                                <i class="fas fa-check fa-xs"></i> Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('superadmin.trial_requests.reject', $r->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-xs btn-delete" title="Reject Request">
                                <i class="fas fa-times fa-xs"></i> Reject
                            </button>
                        </form>
                        @else
                        <span class="text-muted">
                            @if($r->status === 'approved')
                            <i class="fas fa-check-circle text-success"></i> Processed
                            @else
                            <i class="fas fa-times-circle text-danger"></i> Processed
                            @endif
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No trial requests yet</h5>
                        <p>Trial requests will appear here when submitted.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($requests->hasPages())
    <div class="card-footer clearfix">
        <div class="float-left">
            <p class="text-muted mb-0">
                Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} entries
            </p>
        </div>
        <div class="float-right">
            {{ $requests->links() }}
        </div>
    </div>
    @endif
</div>

@endsection