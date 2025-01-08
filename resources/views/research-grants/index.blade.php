@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Research Grants</h2>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('research-grants.create') }}" class="btn btn-primary">Add Research Grant</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @if($grants->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Project Leader</th>
                                <th>Grant Amount</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grants as $grant)
                                <tr>
                                    <td>{{ $grant->title }}</td>
                                    <td>{{ $grant->projectLeader->name }}</td>
                                    <td>RM {{ number_format($grant->grant_amount, 2) }}</td>
                                    <td>{{ $grant->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $grant->duration_months }} months</td>
                                    <td>
                                        <a href="{{ route('research-grants.show', $grant) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('update', $grant)
                                            <a href="{{ route('research-grants.edit', $grant) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endcan
                                        @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('research-grants.destroy', $grant) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure? This will delete all associated milestones.')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No research grants found.</p>
            @endif
        </div>
    </div>
</div>
@endsection 