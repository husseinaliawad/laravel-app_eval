@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Edit KPI</h5>
        <form method="POST" action="{{ route('kpis.update', $kpi) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Course</label>
                    <select class="form-select" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected($kpi->course_id === $course->id)>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input class="form-control" name="name" value="{{ old('name', $kpi->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Weight (%)</label>
                    <input class="form-control" type="number" name="weight" value="{{ old('weight', $kpi->weight) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Target</label>
                    <input class="form-control" type="number" name="target" value="{{ old('target', $kpi->target) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active" @selected($kpi->status === 'active')>Active</option>
                        <option value="inactive" @selected($kpi->status === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $kpi->description) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update KPI</button>
                <a class="btn btn-outline-secondary" href="{{ route('kpis.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
