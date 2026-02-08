<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\Enrollment;
use App\Services\PerformanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Attendance::class);

        $attendances = Attendance::with(['enrollment.student', 'enrollment.section.course'])->paginate(10);
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $this->authorize('create', Attendance::class);

        $enrollments = Enrollment::with(['student', 'section.course'])->get();
        return view('attendance.create', compact('enrollments'));
    }

    public function store(StoreAttendanceRequest $request, PerformanceService $service)
    {
        $this->authorize('create', Attendance::class);

        $data = $request->validated();
        $data['recorded_by'] = auth()->id();

        $attendance = Attendance::create($data);

        $this->logAudit('attendance_created', $attendance, $request);
        $service->evaluateAndNotify($attendance->enrollment->student_id);

        return redirect()->route('attendance.index')->with('status', 'Attendance recorded successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $this->authorize('update', $attendance);

        $enrollments = Enrollment::with(['student', 'section.course'])->get();
        return view('attendance.edit', compact('attendance', 'enrollments'));
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance, PerformanceService $service)
    {
        $this->authorize('update', $attendance);

        $data = $request->validated();
        $data['recorded_by'] = auth()->id();

        $attendance->update($data);

        $this->logAudit('attendance_updated', $attendance, $request);
        $service->evaluateAndNotify($attendance->enrollment->student_id);

        return redirect()->route('attendance.index')->with('status', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);

        $attendance->delete();
        return redirect()->route('attendance.index')->with('status', 'Attendance deleted successfully.');
    }

    private function logAudit(string $action, Attendance $attendance, Request $request): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'context' => json_encode([
                'attendance_id' => $attendance->id,
                'enrollment_id' => $attendance->enrollment_id,
                'status' => $attendance->status,
                'date' => $attendance->attendance_date,
            ]),
            'ip_address' => $request->ip(),
        ]);
    }
}
