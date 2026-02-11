@extends('layouts.app')

@section('title', 'Features')
@section('page-title', 'Feature Management')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Feature List
        </h3>

        <div class="card-tools">
            <a href="{{ route('superadmin.features.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Feature
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $feature->name }}</td>
                    <td><code>{{ $feature->slug }}</code></td>
                    <td>
                        @if($feature->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.features.destroy', $feature->id) }}">
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
                    <td colspan="5" class="text-center text-muted">
                        No features created yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $features->links() }}
    </div>
</div>

@endsection