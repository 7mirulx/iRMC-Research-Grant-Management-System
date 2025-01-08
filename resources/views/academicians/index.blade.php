@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Academicians</h2>
        <a href="{{ route('academicians.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Academician
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Staff Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>College</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($academicians as $academician)
                            <tr>
                                <td>{{ $academician->staff_number }}</td>
                                <td>{{ $academician->name }}</td>
                                <td>{{ $academician->email }}</td>
                                <td>{{ $academician->college }}</td>
                                <td>{{ $academician->department }}</td>
                                <td>{{ $academician->position }}</td>
                                <td>
                                    <a href="{{ route('academicians.show', $academician) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('academicians.edit', $academician) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('academicians.destroy', $academician) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No academicians found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 