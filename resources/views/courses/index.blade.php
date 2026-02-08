@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="mb-0">Courses</h5>
            <a class="btn btn-primary" href="{{ route('courses.create') }}">Add Course</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Credits</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->department->name }}</td>
                            <td>{{ $course->credits }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('courses.edit', $course) }}">Edit</a>
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline">
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
        {{ $courses->links() }}
    </div>
@endsection
