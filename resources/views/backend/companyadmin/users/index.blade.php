@extends('layouts.app')

@section('title','Manage Users')
@section('page-title','User Management')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Company Users
        </h3>

        <div class="card-tools">
            <a href="{{ route('company.users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Add New User
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="120">Role</th>
                    <th width="170">Created Date</th>
                    <th width="150" class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>

                    <td>
                        <i class="fas fa-user-circle text-primary mr-2"></i>
                        <strong>{{ $user->name }}</strong>
                        @if($user->id === auth()->id())
                        <span class="badge badge-light border ml-2">You</span>
                        @endif
                    </td>

                    <td>
                        <i class="fas fa-envelope text-muted mr-1"></i>
                        {{ $user->email }}
                    </td>

                    <td>
                        @php
                        $role = $user->role;
                        $badge = 'badge-info';
                        if ($role === 'company_admin') $badge = 'badge-success';
                        elseif (in_array($role, ['qc','checker'])) $badge = 'badge-warning';
                        elseif (in_array($role, ['engineer','editor','shop'])) $badge = 'badge-primary';
                        @endphp

                        <span class="badge {{ $badge }} px-2 py-1">
                            {{ ucfirst(str_replace('_',' ',$role)) }}
                        </span>
                    </td>

                    <td>
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ $user->created_at->format('M d, Y') }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('company.users.edit', $user->id) }}"
                            class="btn btn-warning btn-sm mr-1"
                            title="Edit User">
                            <i class="fas fa-edit"></i>
                        </a>

                        @if($user->id !== auth()->id())
                        <form method="POST"
                            action="{{ route('company.users.destroy', $user->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm btn-delete"
                                title="Delete User">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @else
                        <button type="button" class="btn btn-secondary btn-sm" disabled title="Can't delete yourself">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3 d-block opacity-50"></i>
                        <h5>No users found</h5>
                        <p>Click "Add New User" to create your first user.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="card-footer clearfix">
        <div class="float-left">
            <p class="text-muted mb-0">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </p>
        </div>
        <div class="float-right">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

@endsection