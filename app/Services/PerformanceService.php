<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Notification;
use Carbon\Carbon;

class PerformanceService
{
    public function getStudentMetrics(int $studentId): array
    {
        $avgGrade = Grade::join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.student_id', $studentId)
            ->avg('grades.score') ?? 0;

        $attendanceStats = Attendance::join('enrollments', 'attendances.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.student_id', $studentId)
            ->selectRaw('SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as present_count')
            ->selectRaw('COUNT(*) as total_count')
            ->first();

        $attendanceRate = 0;
        if ($attendanceStats && $attendanceStats->total_count > 0) {
            $attendanceRate = ($attendanceStats->present_count / $attendanceStats->total_count) * 100;
        }

        return [
            'avg_grade' => $avgGrade,
            'attendance_rate' => $attendanceRate,
        ];
    }

    public function evaluateAndNotify(int $studentId): void
    {
        $metrics = $this->getStudentMetrics($studentId);

        if ($metrics['avg_grade'] < 50 || $metrics['attendance_rate'] < 70) {
            $latest = Notification::where('user_id', $studentId)
                ->where('title', 'Early Warning: Performance Risk')
                ->orderByDesc('created_at')
                ->first();

            if (!$latest || $latest->created_at->lt(Carbon::now()->subDays(7))) {
                Notification::create([
                    'user_id' => $studentId,
                    'title' => 'Early Warning: Performance Risk',
                    'body' => 'Your current grade or attendance is below the threshold. Please contact your advisor.',
                    'severity' => 'danger',
                    'meta' => $metrics,
                ]);
            }
        }
    }
}
