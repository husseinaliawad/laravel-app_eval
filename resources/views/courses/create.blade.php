@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Add Course</h5>
        <form method="POST" action="{{ route('courses.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Code</label>
                    <input class="form-control" name="code" value="{{ old('code') }}" required>
                    @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" value="{{ old('title') }}" required>
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select class="form-select" name="department_id" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Credits</label>
                    <input class="form-control" type="number" name="credits" value="{{ old('credits', 3) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Level</label>
                    <input class="form-control" name="level" value="{{ old('level') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Save Course</button>
                <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
