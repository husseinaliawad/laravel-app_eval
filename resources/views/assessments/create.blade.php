@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Add Assessment</h5>
        <form method="POST" action="{{ route('assessments.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Course</label>
                    <select class="form-select" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type</label>
                    <input class="form-control" name="type" value="{{ old('type', 'Exam') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Weight (%)</label>
                    <input class="form-control" type="number" name="weight" value="{{ old('weight', 30) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Max Score</label>
                    <input class="form-control" type="number" name="max_score" value="{{ old('max_score', 100) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Due Date</label>
                    <input class="form-control" type="date" name="due_date" value="{{ old('due_date') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Save Assessment</button>
                <a class="btn btn-outline-secondary" href="{{ route('assessments.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
