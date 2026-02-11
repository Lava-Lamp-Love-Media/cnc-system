@extends('layouts.app')

@section('title','Companies')
@section('page-title','Company Management')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-building"></i> Companies</h3>
        <div class="card-tools">
            <a href="{{ route('superadmin.companies.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Company
            </a>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td>
                        @if($company->plan)
                        <span class="badge badge-info">
                            {{ $company->plan->name }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-success">
                            {{ ucfirst($company->status) }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.companies.destroy',$company->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection