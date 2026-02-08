<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $studentCount = User::role('Student')->count();
        $courseCount = Course::count();

        $avgGrade = Grade::avg('score') ?? 0;

        $attendanceStats = Attendance::selectRaw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count')
            ->selectRaw('COUNT(*) as total_count')
            ->first();
        $avgAttendance = 0;
        if ($attendanceStats && $attendanceStats->total_count > 0) {
            $avgAttendance = ($attendanceStats->present_count / $attendanceStats->total_count) * 100;
        }

        $riskQuery = User::role('Student')->select('users.id')
            ->leftJoin('enrollments', 'users.id', '=', 'enrollments.student_id')
            ->leftJoin('grades', 'enrollments.id', '=', 'grades.enrollment_id')
            ->leftJoin('attendances', 'enrollments.id', '=', 'attendances.enrollment_id')
            ->groupBy('users.id')
            ->selectRaw('AVG(grades.score) as avg_grade')
            ->selectRaw('100.0 * SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) / NULLIF(COUNT(attendances.id),0) as attendance_rate');

        $atRiskCount = DB::query()
            ->fromSub($riskQuery, 'student_stats')
            ->where(function ($q) {
                $q->where('avg_grade', '<', 50)->orWhere('attendance_rate', '<', 70);
            })
            ->count();

        $recentGrades = Grade::with(['enrollment.student', 'assessment.course'])
            ->orderByDesc('graded_at')
            ->take(5)
            ->get();

        return view('dashboard', [
            'avgGrade' => $avgGrade,
            'avgAttendance' => $avgAttendance,
            'atRiskCount' => $atRiskCount,
            'courseCount' => $courseCount,
            'studentCount' => $studentCount,
            'recentGrades' => $recentGrades,
        ]);
    }
}
