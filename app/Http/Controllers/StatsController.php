<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $trendRows = DB::table('grades')
            ->selectRaw('DATE_FORMAT(COALESCE(graded_at, created_at), "%b %y") as label')
            ->selectRaw('AVG(score) as avg_score')
            ->groupBy('label')
            ->orderByRaw('MIN(COALESCE(graded_at, created_at))')
            ->limit(6)
            ->get();

        $trend = [
            'labels' => $trendRows->pluck('label'),
            'values' => $trendRows->pluck('avg_score'),
        ];
        if ($trendRows->isEmpty()) {
            $trend = ['labels' => ['N/A'], 'values' => [0]];
        }

        $deptRows = DB::table('grades')
            ->join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->join('sections', 'enrollments.section_id', '=', 'sections.id')
            ->join('courses', 'sections.course_id', '=', 'courses.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->select('departments.name')
            ->selectRaw('AVG(grades.score) as avg_score')
            ->groupBy('departments.name')
            ->get();

        $departmentKpis = [
            'labels' => $deptRows->pluck('name'),
            'values' => $deptRows->pluck('avg_score'),
        ];
        if ($deptRows->isEmpty()) {
            $departmentKpis = ['labels' => ['N/A'], 'values' => [0]];
        }

        $studentStats = DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', '=', 'App\\Models\\User');
            })
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->leftJoin('enrollments', 'users.id', '=', 'enrollments.student_id')
            ->leftJoin('grades', 'enrollments.id', '=', 'grades.enrollment_id')
            ->where('roles.name', 'Student')
            ->groupBy('users.id')
            ->selectRaw('AVG(grades.score) as avg_grade')
            ->selectRaw('COUNT(grades.id) as grade_count')
            ->get();

        $passCount = $studentStats->filter(fn ($row) => $row->avg_grade !== null && $row->avg_grade >= 50)->count();
        $failCount = $studentStats->filter(fn ($row) => $row->avg_grade !== null && $row->avg_grade < 50)->count();
        $inProgress = $studentStats->filter(fn ($row) => $row->grade_count == 0)->count();

        $completion = [
            'labels' => ['Pass', 'In Progress', 'Fail'],
            'values' => [$passCount, $inProgress, $failCount],
        ];

        $gapHigh = $studentStats->filter(fn ($row) => $row->avg_grade !== null && $row->avg_grade < 60)->count();
        $gapMedium = $studentStats->filter(fn ($row) => $row->avg_grade !== null && $row->avg_grade >= 60 && $row->avg_grade < 75)->count();
        $gapLow = $studentStats->filter(fn ($row) => $row->avg_grade !== null && $row->avg_grade >= 75)->count();

        $gaps = [
            'labels' => ['High Gap (<60)', 'Moderate (60-75)', 'On Track (>75)'],
            'values' => [$gapHigh, $gapMedium, $gapLow],
        ];

        return response()->json([
            'trend' => $trend,
            'department_kpis' => $departmentKpis,
            'completion' => $completion,
            'gaps' => $gaps,
        ]);
    }
}
