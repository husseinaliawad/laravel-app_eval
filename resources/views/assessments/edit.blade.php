@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Edit Assessment</h5>
        <form method="POST" action="{{ route('assessments.update', $assessment) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Course</label>
                    <select class="form-select" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected($assessment->course_id === $course->id)>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" value="{{ old('title', $assessment->title) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type</label>
                    <input class="form-control" name="type" value="{{ old('type', $assessment->type) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Weight (%)</label>
                    <input class="form-control" type="number" name="weight" value="{{ old('weight', $assessment->weight) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Max Score</label>
                    <input class="form-control" type="number" name="max_score" value="{{ old('max_score', $assessment->max_score) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Due Date</label>
                    <input class="form-control" type="date" name="due_date" value="{{ old('due_date', optional($assessment->due_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $assessment->description) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update Assessment</button>
                <a class="btn btn-outline-secondary" href="{{ route('assessments.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
