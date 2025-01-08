@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Research Grant</h2>
        <a href="{{ route('research-grants.show', $research_grant) }}" class="btn btn-secondary">Back to Details</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('research-grants.update', $research_grant) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $research_grant->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="grant_amount" class="form-label">Grant Amount (RM)</label>
                    <input type="number" step="0.01" class="form-control @error('grant_amount') is-invalid @enderror" 
                           id="grant_amount" name="grant_amount" value="{{ old('grant_amount', $research_grant->grant_amount) }}" required>
                    @error('grant_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="grant_provider" class="form-label">Grant Provider</label>
                    <input type="text" class="form-control @error('grant_provider') is-invalid @enderror" 
                           id="grant_provider" name="grant_provider" value="{{ old('grant_provider', $research_grant->grant_provider) }}" required>
                    @error('grant_provider')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                           id="start_date" name="start_date" value="{{ old('start_date', $research_grant->start_date->format('Y-m-d')) }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="duration_months" class="form-label">Duration (months)</label>
                    <input type="number" class="form-control @error('duration_months') is-invalid @enderror" 
                           id="duration_months" name="duration_months" value="{{ old('duration_months', $research_grant->duration_months) }}" required>
                    @error('duration_months')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="members" class="form-label">Project Members</label>
                    <select class="form-select @error('members') is-invalid @enderror" 
                            id="members" name="members[]" multiple required>
                        @foreach($academicians as $academician)
                            <option value="{{ $academician->id }}" 
                                {{ in_array($academician->id, old('members', $research_grant->members->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $academician->name }} - {{ $academician->position }}
                            </option>
                        @endforeach
                    </select>
                    @error('members')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Research Grant</button>
            </form>
        </div>
    </div>
</div>
@endsection 