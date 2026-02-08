@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-elevated">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">KPI Indicators</h5>
                    <a class="btn btn-primary btn-sm" href="{{ route('kpis.create') }}">Add KPI</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Name</th>
                                <th>Weight</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kpis as $kpi)
                                <tr>
                                    <td>{{ $kpi->course->title }}</td>
                                    <td>{{ $kpi->name }}</td>
                                    <td>{{ $kpi->weight }}%</td>
                                    <td>{{ $kpi->target }}</td>
                                    <td>{{ ucfirst($kpi->status) }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('kpis.edit', $kpi) }}">Edit</a>
                                        <form method="POST" action="{{ route('kpis.destroy', $kpi) }}" class="d-inline">
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
                {{ $kpis->links() }}
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card-elevated h-100">
                <h6 class="mb-3">Early Warning Rules</h6>
                <ul class="list-unstyled warning-rules">
                    <li><span class="badge badge-soft-danger">Rule</span> Grade &lt; 50 OR Attendance &lt; 70% triggers alert</li>
                    <li><span class="badge badge-soft-warning">Rule</span> KPI below 60% for two weeks</li>
                    <li><span class="badge badge-soft-info">Rule</span> Sudden drop &gt; 15% in trend line</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
