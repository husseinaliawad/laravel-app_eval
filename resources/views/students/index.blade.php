@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <form class="input-group w-auto" method="GET" action="{{ route('students.index') }}">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input class="form-control" type="search" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </form>
            <a class="btn btn-primary" href="{{ route('students.create') }}">Add Student</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Student ID</th>
                        <th>Department</th>
                        <th>Average Grade</th>
                        <th>Attendance</th>
                        <th>Risk</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        @php
                            $avgGrade = $student->avg_grade ?? 0;
                            $attendanceRate = $student->attendance_rate ?? 0;
                            $riskLabel = 'Low';
                            $riskClass = 'badge-soft-success';
                            if ($avgGrade < 50 || $attendanceRate < 70) {
                                $riskLabel = 'High';
                                $riskClass = 'badge-soft-danger';
                            } elseif ($avgGrade < 65 || $attendanceRate < 80) {
                                $riskLabel = 'Medium';
                                $riskClass = 'badge-soft-warning';
                            }
                        @endphp
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->student_number }}</td>
                            <td>{{ $student->department?->name ?? 'N/A' }}</td>
                            <td>{{ number_format($avgGrade, 1) }}%</td>
                            <td>{{ number_format($attendanceRate, 1) }}%</td>
                            <td><span class="badge {{ $riskClass }}">{{ $riskLabel }}</span></td>
                            <td>
                                <span class="badge {{ $student->status === 'active' ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('students.edit', $student) }}">Edit</a>
                                <form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline">
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
        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
@endsection
