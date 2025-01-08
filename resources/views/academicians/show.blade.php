@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Academician Details</h2>
        <div>
            <a href="{{ route('academicians.edit', $academician) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('academicians.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Staff Number</th>
                            <td>{{ $academician->staff_number }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $academician->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $academician->email }}</td>
                        </tr>
                        <tr>
                            <th>Position</th>
                            <td>{{ $academician->position }}</td>
                        </tr>
                        <tr>
                            <th>College</th>
                            <td>{{ $academician->college }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ $academician->department }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Research Grants as Project Leader</h5>
                </div>
                <div class="card-body">
                    @if($academician->ledProjects->count() > 0)
                        <div class="list-group">
                            @foreach($academician->ledProjects as $project)
                                <a href="{{ route('research-grants.show', $project) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $project->title }}</h6>
                                        <small>{{ $project->start_date->format('M Y') }}</small>
                                    </div>
                                    <p class="mb-1">Grant Amount: RM {{ number_format($project->grant_amount, 2) }}</p>
                                    <small>Provider: {{ $project->grant_provider }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No research grants as project leader.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Research Grants as Member</h5>
                </div>
                <div class="card-body">
                    @if($academician->memberProjects->count() > 0)
                        <div class="list-group">
                            @foreach($academician->memberProjects as $project)
                                <a href="{{ route('research-grants.show', $project) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $project->title }}</h6>
                                        <small>{{ $project->start_date->format('M Y') }}</small>
                                    </div>
                                    <p class="mb-1">Project Leader: {{ $project->projectLeader->name }}</p>
                                    <small>Provider: {{ $project->grant_provider }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No research grants as member.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 