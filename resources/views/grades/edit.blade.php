@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Edit Grade</h5>
        <form method="POST" action="{{ route('grades.update', $grade) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Enrollment</label>
                    <select class="form-select" name="enrollment_id" required>
                        @foreach ($enrollments as $enrollment)
                            <option value="{{ $enrollment->id }}" @selected($grade->enrollment_id === $enrollment->id)>
                                {{ $enrollment->student->name }} - {{ $enrollment->section->course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Assessment</label>
                    <select class="form-select" name="assessment_id" required>
                        @foreach ($assessments as $assessment)
                            <option value="{{ $assessment->id }}" @selected($grade->assessment_id === $assessment->id)>{{ $assessment->course->title }} - {{ $assessment->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Score</label>
                    <input class="form-control" type="number" step="0.01" name="score" value="{{ old('score', $grade->score) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Graded At</label>
                    <input class="form-control" type="date" name="graded_at" value="{{ old('graded_at', optional($grade->graded_at)->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" name="notes" rows="3">{{ old('notes', $grade->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update Grade</button>
                <a class="btn btn-outline-secondary" href="{{ route('grades.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
