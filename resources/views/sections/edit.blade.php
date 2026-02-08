@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Edit Section</h5>
        <form method="POST" action="{{ route('sections.update', $section) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Course</label>
                    <select class="form-select" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected($section->course_id === $course->id)>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Semester</label>
                    <select class="form-select" name="semester_id" required>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" @selected($section->semester_id === $semester->id)>{{ $semester->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Instructor</label>
                    <select class="form-select" name="instructor_id">
                        <option value="">Assign Later</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}" @selected($section->instructor_id === $instructor->id)>{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section Code</label>
                    <input class="form-control" name="section_code" value="{{ old('section_code', $section->section_code) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Capacity</label>
                    <input class="form-control" type="number" name="capacity" value="{{ old('capacity', $section->capacity) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Schedule</label>
                    <input class="form-control" name="schedule" value="{{ old('schedule', $section->schedule) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input class="form-control" name="location" value="{{ old('location', $section->location) }}">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update Section</button>
                <a class="btn btn-outline-secondary" href="{{ route('sections.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
