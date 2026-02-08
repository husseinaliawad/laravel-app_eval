@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="mb-0">Attendance</h5>
            <a class="btn btn-primary" href="{{ route('attendance.create') }}">Add Attendance</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->enrollment->student->name }}</td>
                            <td>{{ $attendance->enrollment->section->course->title }}</td>
                            <td>{{ optional($attendance->attendance_date)->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($attendance->status) }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('attendance.edit', $attendance) }}">Edit</a>
                                <form method="POST" action="{{ route('attendance.destroy', $attendance) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $attendances->links() }}
    </div>
@endsection
