@extends('layouts.app')

@section('content')
    <div class="card-elevated">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="mb-0">Assessments</h5>
            <a class="btn btn-primary" href="{{ route('assessments.create') }}">Add Assessment</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Max Score</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assessments as $assessment)
                        <tr>
                            <td>{{ $assessment->course->title }}</td>
                            <td>{{ $assessment->title }}</td>
                            <td>{{ $assessment->type }}</td>
                            <td>{{ $assessment->weight }}%</td>
                            <td>{{ $assessment->max_score }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('assessments.edit', $assessment) }}">Edit</a>
                                <form method="POST" action="{{ route('assessments.destroy', $assessment) }}" class="d-inline">
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
        {{ $assessments->links() }}
    </div>
@endsection
