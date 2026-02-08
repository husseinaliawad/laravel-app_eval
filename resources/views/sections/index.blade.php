@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="mb-0">Sections</h5>
            <a class="btn btn-primary" href="{{ route('sections.create') }}">Add Section</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Instructor</th>
                        <th>Section</th>
                        <th>Capacity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr>
                            <td>{{ $section->course->title }}</td>
                            <td>{{ $section->semester->name }}</td>
                            <td>{{ $section->instructor?->name ?? 'TBD' }}</td>
                            <td>{{ $section->section_code }}</td>
                            <td>{{ $section->capacity }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('sections.edit', $section) }}">Edit</a>
                                <form method="POST" action="{{ route('sections.destroy', $section) }}" class="d-inline">
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
        {{ $sections->links() }}
    </div>
@endsection
