@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Milestones Management</h2>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
                <i class="bi bi-plus-lg"></i> Add New Milestone
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Back to Dashboard</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($milestones->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Research Grant</th>
                                <th>Project Leader</th>
                                <th>Deliverable</th>
                                <th>Target Date</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($milestones as $milestone)
                                <tr>
                                    <td>{{ $milestone->name }}</td>
                                    <td>{{ $milestone->researchGrant->title }}</td>
                                    <td>{{ $milestone->researchGrant->projectLeader->name }}</td>
                                    <td>{{ $milestone->deliverable }}</td>
                                    <td>{{ $milestone->target_completion_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $milestone->status === 'completed' ? 'success' : ($milestone->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ str_replace('_', ' ', ucfirst($milestone->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $milestone->last_updated ? $milestone->last_updated->format('d/m/Y H:i') : 'Not updated' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('milestones.editstatus', $milestone) }}" 
                                               class="btn btn-sm btn-warning" title="Update Status">
                                                <i class="bi bi-clock-history"></i>
                                            </a>
                                            <form action="{{ route('milestones.destroy', $milestone) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this milestone?')"
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No milestones found.</p>
            @endif
        </div>
    </div>
</div>

<!-- Add Milestone Modal -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Milestone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('milestones.admin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="research_grant_id" class="form-label">Research Grant</label>
                        <select class="form-select" id="research_grant_id" name="research_grant_id" required>
                            <option value="">Select Research Grant</option>
                            @foreach($researchGrants as $grant)
                                <option value="{{ $grant->id }}">
                                    {{ $grant->title }} (Leader: {{ $grant->projectLeader->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Milestone Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="deliverable" class="form-label">Deliverable</label>
                        <textarea class="form-control" id="deliverable" name="deliverable" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="target_completion_date" class="form-label">Target Completion Date</label>
                        <input type="date" class="form-control" id="target_completion_date" 
                               name="target_completion_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Milestone</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 