@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Research Grant</h2>
        <a href="{{ route('research-grants.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('research-grants.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="project_leader_id" class="form-label">Project Leader</label>
                        <select class="form-select @error('project_leader_id') is-invalid @enderror" 
                            id="project_leader_id" name="project_leader_id" required>
                            <option value="">Select Project Leader</option>
                            @foreach($academicians as $academician)
                                <option value="{{ $academician->id }}" {{ old('project_leader_id') == $academician->id ? 'selected' : '' }}>
                                    {{ $academician->name }} ({{ $academician->staff_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('project_leader_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                            id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="grant_amount" class="form-label">Grant Amount (RM)</label>
                        <input type="number" step="0.01" class="form-control @error('grant_amount') is-invalid @enderror" 
                            id="grant_amount" name="grant_amount" value="{{ old('grant_amount') }}" required>
                        @error('grant_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="grant_provider" class="form-label">Grant Provider</label>
                        <input type="text" class="form-control @error('grant_provider') is-invalid @enderror" 
                            id="grant_provider" name="grant_provider" value="{{ old('grant_provider') }}" required>
                        @error('grant_provider')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                            id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="duration_months" class="form-label">Duration (Months)</label>
                        <input type="number" class="form-control @error('duration_months') is-invalid @enderror" 
                            id="duration_months" name="duration_months" value="{{ old('duration_months') }}" required>
                        @error('duration_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="members" class="form-label">Project Members</label>
                        <select class="form-select @error('members') is-invalid @enderror" 
                            id="members" name="members[]" multiple required>
                            @foreach($academicians as $academician)
                                <option value="{{ $academician->id }}" 
                                    {{ (old('members') && in_array($academician->id, old('members'))) ? 'selected' : '' }}>
                                    {{ $academician->name }} ({{ $academician->staff_number }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Hold Ctrl/Cmd to select multiple members</div>
                        @error('members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create Research Grant</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 