@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Milestone</h2>
        <div>
            <a href="{{ route('research-grants.show', $research_grant) }}" class="btn btn-secondary">Back</a>
            <form action="{{ route('milestones.destroy', $milestone) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this milestone?')">
                    Delete Milestone
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('milestones.update', $milestone) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $milestone->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deliverable" class="form-label">Deliverable</label>
                    <textarea class="form-control" id="deliverable" name="deliverable" 
                            rows="3" required>{{ old('deliverable', $milestone->deliverable) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="target_completion_date" class="form-label">Target Completion Date</label>
                    <input type="date" class="form-control" id="target_completion_date" 
                           name="target_completion_date" 
                           value="{{ old('target_completion_date', $milestone->target_completion_date->format('Y-m-d')) }}" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="not_started" {{ $milestone->status === 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ $milestone->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $milestone->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="members" class="form-label">Project Members</label>
                    <select class="form-select" id="members" name="members[]" multiple required>
                        @foreach($academicians as $academician)
                            <option value="{{ $academician->id }}" 
                                {{ in_array($academician->id, $research_grant->members->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $academician->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple members</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Milestone</button>
            </form>
        </div>
    </div>
</div>
@endsection 