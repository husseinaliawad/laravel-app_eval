<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $studentGrades = User::role('Student')
            ->leftJoin('enrollments', 'users.id', '=', 'enrollments.student_id')
            ->leftJoin('grades', 'enrollments.id', '=', 'grades.enrollment_id')
            ->groupBy('users.id', 'users.name')
            ->select('users.id', 'users.name')
            ->selectRaw('AVG(grades.score) as avg_grade');

        $topStudents = DB::query()
            ->fromSub($studentGrades, 'stats')
            ->orderByDesc('avg_grade')
            ->limit(5)
            ->get();

        $lowStudents = DB::query()
            ->fromSub($studentGrades, 'stats')
            ->orderBy('avg_grade')
            ->limit(5)
            ->get();

        return view('reports.index', compact('topStudents', 'lowStudents'));
    }
}
