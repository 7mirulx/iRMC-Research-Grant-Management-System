@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Academician</h2>
        <a href="{{ route('academicians.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('academicians.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="staff_number" class="form-label">Staff Number</label>
                        <input type="text" class="form-control @error('staff_number') is-invalid @enderror" 
                            id="staff_number" name="staff_number" value="{{ old('staff_number') }}" required>
                        @error('staff_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="position" class="form-label">Position</label>
                        <select class="form-select @error('position') is-invalid @enderror" 
                            id="position" name="position" required>
                            <option value="">Select Position</option>
                            <option value="Professor" {{ old('position') == 'Professor' ? 'selected' : '' }}>Professor</option>
                            <option value="Associate Professor" {{ old('position') == 'Associate Professor' ? 'selected' : '' }}>Associate Professor</option>
                            <option value="Senior Lecturer" {{ old('position') == 'Senior Lecturer' ? 'selected' : '' }}>Senior Lecturer</option>
                            <option value="Lecturer" {{ old('position') == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="college" class="form-label">College</label>
                        <input type="text" class="form-control @error('college') is-invalid @enderror" 
                            id="college" name="college" value="{{ old('college') }}" required>
                        @error('college')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control @error('department') is-invalid @enderror" 
                            id="department" name="department" value="{{ old('department') }}" required>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create Academician</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 