@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="mb-0">Grades</h5>
            <a class="btn btn-primary" href="{{ route('grades.create') }}">Add Grade</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Assessment</th>
                        <th>Score</th>
                        <th>Graded At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades as $grade)
                        <tr>
                            <td>{{ $grade->enrollment->student->name }}</td>
                            <td>{{ $grade->assessment->course->title }}</td>
                            <td>{{ $grade->assessment->title }}</td>
                            <td>{{ number_format($grade->score, 1) }}%</td>
                            <td>{{ optional($grade->graded_at)->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('grades.edit', $grade) }}">Edit</a>
                                <form method="POST" action="{{ route('grades.destroy', $grade) }}" class="d-inline">
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
        {{ $grades->links() }}
    </div>
@endsection
