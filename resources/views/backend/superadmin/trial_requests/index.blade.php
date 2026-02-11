@extends('layouts.app')

@section('title','Trial Requests')
@section('page-title','Trial Requests')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-inbox"></i> Trial Requests</h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Preferred Plan</th>
                    <th>Status</th>
                    <th>Requested</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $r)
                <tr>
                    <td>
                        <b>{{ $r->company_name }}</b><br>
                        <small class="text-muted">{{ $r->company_email }}</small>
                    </td>
                    <td>
                        {{ $r->contact_name }}<br>
                        <small class="text-muted">{{ $r->contact_email }}</small>
                    </td>
                    <td><code>{{ $r->preferred_plan_slug ?? '—' }}</code></td>
                    <td>
                        @if($r->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($r->status === 'approved')
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $r->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($r->status === 'pending')
                        <form method="POST" action="{{ route('superadmin.trial_requests.approve', $r->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('superadmin.trial_requests.reject', $r->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No trial requests yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $requests->links() }}
    </div>
</div>

@endsection
