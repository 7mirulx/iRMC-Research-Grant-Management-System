@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Research Grant Details</h2>
        <div>
            @can('update', $research_grant)
                <a href="{{ route('research-grants.edit', $research_grant) }}" class="btn btn-primary">Edit</a>
            @endcan
            <a href="{{ route('research-grants.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $research_grant->title }}</h5>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>Project Leader:</strong> {{ $research_grant->projectLeader->name }}</p>
                    <p><strong>Grant Amount:</strong> RM {{ number_format($research_grant->grant_amount, 2) }}</p>
                    <p><strong>Grant Provider:</strong> {{ $research_grant->grant_provider }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Start Date:</strong> {{ $research_grant->start_date->format('d/m/Y') }}</p>
                    <p><strong>Duration:</strong> {{ $research_grant->duration_months }} months</p>
                </div>
            </div>

            <div class="mt-4">
                <h6>Project Members:</h6>
                <ul class="list-unstyled">
                    @foreach($research_grant->members as $member)
                        <li>{{ $member->name }} - {{ $member->position }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Milestones:</h6>
                    @can('manage-milestones', $research_grant)
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
                            Add Milestone
                        </button>
                    @endcan
                </div>
                @if($research_grant->milestones->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Deliverable</th>
                                    <th>Target Date</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    @can('manage-milestones', $research_grant)
                                        <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($research_grant->milestones as $milestone)
                                    <tr>
                                        <td>{{ $milestone->name }}</td>
                                        <td>{{ $milestone->deliverable }}</td>
                                        <td>{{ $milestone->target_completion_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $milestone->status }}">
                                                {{ str_replace('_', ' ', ucfirst($milestone->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $milestone->last_updated ? $milestone->last_updated->format('d/m/Y H:i') : 'Not updated' }}</td>
                                        @can('manage-milestones', $research_grant)
                                            <td>
                                                <a href="{{ route('milestones.editstatus', $milestone) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> Update Status
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No milestones added yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@can('manage-milestones', $research_grant)
<!-- Add Milestone Modal -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Milestone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('milestones.store', $research_grant) }}" method="POST">
                @csrf
                <div class="modal-body">
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
                        <input type="date" class="form-control" id="target_completion_date" name="target_completion_date" required>
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

<!-- Edit Milestone Modal -->
<div class="modal fade" id="editMilestoneModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Milestone Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editMilestoneForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@push('scripts')
<script>
function editMilestone(id) {
    const form = document.getElementById('editMilestoneForm');
    form.action = `/milestones/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('editMilestoneModal'));
    modal.show();
}
</script>
@endpush
@endsection 