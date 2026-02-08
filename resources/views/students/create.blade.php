@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Add Student</h5>
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Student Number</label>
                    <input class="form-control" name="student_number" value="{{ old('student_number') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select class="form-select" name="department_id">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input class="form-control" name="phone" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Save Student</button>
                <a class="btn btn-outline-secondary" href="{{ route('students.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
