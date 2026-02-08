@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <h5 class="mb-3">Edit Attendance</h5>
        <form method="POST" action="{{ route('attendance.update', $attendance) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Enrollment</label>
                    <select class="form-select" name="enrollment_id" required>
                        @foreach ($enrollments as $enrollment)
                            <option value="{{ $enrollment->id }}" @selected($attendance->enrollment_id === $enrollment->id)>
                                {{ $enrollment->student->name }} - {{ $enrollment->section->course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input class="form-control" type="date" name="attendance_date" value="{{ old('attendance_date', optional($attendance->attendance_date)->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="present" @selected($attendance->status === 'present')>Present</option>
                        <option value="late" @selected($attendance->status === 'late')>Late</option>
                        <option value="absent" @selected($attendance->status === 'absent')>Absent</option>
                        <option value="excused" @selected($attendance->status === 'excused')>Excused</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update Attendance</button>
                <a class="btn btn-outline-secondary" href="{{ route('attendance.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
