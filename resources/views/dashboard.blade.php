@extends('layouts.app')

@section('content')
    <div class="app-topbar">
        <div>
            <h6 class="mb-1">Academic Performance Dashboard</h6>
            <small class="text-muted">Spring 2026 | Faculty of Informatics</small>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('reports.index') }}">Export PDF</a>
            @can('kpis.create')
                <a class="btn btn-sm btn-primary" href="{{ route('kpis.index') }}">New KPI</a>
            @endcan
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="kpi-card">
                <span>Average Grade</span>
                <h4>{{ number_format($avgGrade, 1) }}%</h4>
                <small class="text-success">Current semester</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <span>Attendance Rate</span>
                <h4>{{ number_format($avgAttendance, 1) }}%</h4>
                <small class="text-success">Current semester</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <span>At-Risk Students</span>
                <h4>{{ $atRiskCount }}</h4>
                <small class="text-warning">Needs review</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <span>Active Courses</span>
                <h4>{{ $courseCount }}</h4>
                <small class="text-muted">{{ $studentCount }} students</small>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2" data-stats-url="{{ route('stats.index') }}">
        <div class="col-lg-8">
            <div class="card-elevated h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Performance Trend</h6>
                    <span class="badge badge-soft-primary">Last 6 intervals</span>
                </div>
                <canvas id="trendChart" height="140"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-elevated h-100">
                <h6>Recent Evaluations</h6>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Score</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentGrades as $grade)
                                <tr>
                                    <td>{{ $grade->enrollment->student->name }}</td>
                                    <td>{{ number_format($grade->score, 1) }}%</td>
                                    <td>{{ $grade->assessment->course->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small class="text-muted">Last refresh: <span id="refreshTime">just now</span></small>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-lg-6" data-reveal>
            <div class="card-elevated h-100">
                <h6 class="mb-3">Department KPI Distribution</h6>
                <canvas id="kpiBarChart" height="220"></canvas>
            </div>
        </div>
        <div class="col-lg-3" data-reveal>
            <div class="card-elevated h-100">
                <h6 class="mb-3">Completion Status</h6>
                <canvas id="completionPie" height="220"></canvas>
            </div>
        </div>
        <div class="col-lg-3" data-reveal>
            <div class="card-elevated h-100">
                <h6 class="mb-3">Learning Gaps</h6>
                <canvas id="gapDonut" height="220"></canvas>
            </div>
        </div>
    </div>
@endsection
