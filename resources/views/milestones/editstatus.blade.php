@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Update Milestone Status</h2>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('milestones.index') }}" class="btn btn-secondary">Back to Milestones</a>
        @else
            <a href="{{ route('research-grants.show', $milestone->research_grant_id) }}" class="btn btn-secondary">Back to Research Grant</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h5>Milestone Details</h5>
                <dl class="row">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $milestone->name }}</dd>

                    <dt class="col-sm-3">Deliverable</dt>
                    <dd class="col-sm-9">{{ $milestone->deliverable }}</dd>

                    <dt class="col-sm-3">Target Date</dt>
                    <dd class="col-sm-9">{{ $milestone->target_completion_date->format('d/m/Y') }}</dd>

                    <dt class="col-sm-3">Current Status</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $milestone->status === 'completed' ? 'success' : ($milestone->status === 'in_progress' ? 'warning' : 'secondary') }}">
                            {{ str_replace('_', ' ', ucfirst($milestone->status)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Last Updated</dt>
                    <dd class="col-sm-9">{{ $milestone->last_updated ? $milestone->last_updated->format('d/m/Y H:i') : 'Not updated' }}</dd>
                </dl>
            </div>

            <form action="{{ route('milestones.updatestatus', $milestone) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Update Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="not_started" {{ $milestone->status === 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ $milestone->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $milestone->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection 