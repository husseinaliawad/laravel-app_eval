@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Add KPI</h5>
        <form method="POST" action="{{ route('kpis.store') }}">
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
                    <label class="form-label">Name</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Weight (%)</label>
                    <input class="form-control" type="number" name="weight" value="{{ old('weight', 20) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Target</label>
                    <input class="form-control" type="number" name="target" value="{{ old('target', 75) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Save KPI</button>
                <a class="btn btn-outline-secondary" href="{{ route('kpis.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
