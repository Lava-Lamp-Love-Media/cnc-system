@extends('layouts.app')

@section('title', 'Plans')
@section('page-title', 'Plan Management')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-crown"></i> Plan List
        </h3>

        <div class="card-tools">
            <a href="{{ route('superadmin.plans.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Plan
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Features</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>${{ number_format($plan->price, 2) }}</td>
                    <td>{{ $plan->duration_days }} days</td>
                    <td>
                        @foreach($plan->features as $feature)
                        <span class="badge badge-info">{{ $feature->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.plans.destroy', $plan->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No plans created yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $plans->links() }}
    </div>
</div>

@endsection