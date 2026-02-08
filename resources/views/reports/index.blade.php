@extends('layouts.app')

@section('content')
    <div class="card-elevated mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Reports Center</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary">Export PDF</button>
                <button class="btn btn-sm btn-outline-secondary">Export Excel</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Report</th>
                        <th>Owner</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Faculty KPI Summary</td>
                        <td>Quality Office</td>
                        <td>Jan 18, 2026</td>
                        <td><span class="badge badge-soft-success">Published</span></td>
                    </tr>
                    <tr>
                        <td>At-Risk Cohort</td>
                        <td>Advising</td>
                        <td>Jan 21, 2026</td>
                        <td><span class="badge badge-soft-warning">Review</span></td>
                    </tr>
                    <tr>
                        <td>Course Assessment Audit</td>
                        <td>Instructor</td>
                        <td>Jan 23, 2026</td>
                        <td><span class="badge badge-soft-info">Draft</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-elevated">
                <h6 class="mb-3">Top Performers</h6>
                <ul class="list-group list-group-flush">
                    @foreach ($topStudents as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $student->name }}</span>
                            <span class="fw-semibold">{{ number_format($student->avg_grade, 1) }}%</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-elevated">
                <h6 class="mb-3">Low Performers</h6>
                <ul class="list-group list-group-flush">
                    @foreach ($lowStudents as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $student->name }}</span>
                            <span class="fw-semibold text-danger">{{ number_format($student->avg_grade, 1) }}%</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
