<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Assessment;
use App\Models\AuditLog;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Services\PerformanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Grade::class);

        $grades = Grade::with(['enrollment.student', 'assessment.course'])->paginate(10);
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $this->authorize('create', Grade::class);

        $enrollments = Enrollment::with(['student', 'section.course'])->get();
        $assessments = Assessment::with('course')->get();

        return view('grades.create', compact('enrollments', 'assessments'));
    }

    public function store(StoreGradeRequest $request, PerformanceService $service)
    {
        $this->authorize('create', Grade::class);

        $data = $request->validated();
        $data['graded_by'] = auth()->id();
        $data['graded_at'] = $data['graded_at'] ?? Carbon::now();

        $grade = Grade::create($data);

        $this->logAudit('grade_created', $grade, $request);
        $service->evaluateAndNotify($grade->enrollment->student_id);

        return redirect()->route('grades.index')->with('status', 'Grade created successfully.');
    }

    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);

        $enrollments = Enrollment::with(['student', 'section.course'])->get();
        $assessments = Assessment::with('course')->get();

        return view('grades.edit', compact('grade', 'enrollments', 'assessments'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade, PerformanceService $service)
    {
        $this->authorize('update', $grade);

        $data = $request->validated();
        $data['graded_by'] = auth()->id();
        $data['graded_at'] = $data['graded_at'] ?? Carbon::now();

        $grade->update($data);

        $this->logAudit('grade_updated', $grade, $request);
        $service->evaluateAndNotify($grade->enrollment->student_id);

        return redirect()->route('grades.index')->with('status', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);

        $grade->delete();
        return redirect()->route('grades.index')->with('status', 'Grade deleted successfully.');
    }

    private function logAudit(string $action, Grade $grade, Request $request): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'context' => json_encode([
                'grade_id' => $grade->id,
                'enrollment_id' => $grade->enrollment_id,
                'assessment_id' => $grade->assessment_id,
                'score' => $grade->score,
            ]),
            'ip_address' => $request->ip(),
        ]);
    }
}
