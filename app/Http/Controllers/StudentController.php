<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->string('search')->toString();

        $gradeSub = Grade::selectRaw('AVG(grades.score)')
            ->join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->whereColumn('enrollments.student_id', 'users.id');

        $attendanceSub = Attendance::selectRaw(
            '100.0 * SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)'
        )
            ->join('enrollments', 'attendances.enrollment_id', '=', 'enrollments.id')
            ->whereColumn('enrollments.student_id', 'users.id');

        $students = User::role('Student')
            ->with('department')
            ->select('users.*')
            ->selectSub($gradeSub, 'avg_grade')
            ->selectSub($attendanceSub, 'attendance_rate')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('users.student_number', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $departments = Department::orderBy('name')->get();
        return view('students.create', compact('departments'));
    }

    public function store(StoreStudentRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $student = User::create($data);
        $student->assignRole('Student');

        return redirect()->route('students.index')->with('status', 'Student created successfully.');
    }

    public function edit(User $student)
    {
        $this->authorize('update', $student);

        $departments = Department::orderBy('name')->get();
        return view('students.edit', compact('student', 'departments'));
    }

    public function update(UpdateStudentRequest $request, User $student)
    {
        $this->authorize('update', $student);

        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $student->update($data);

        return redirect()->route('students.index')->with('status', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        $this->authorize('delete', $student);

        $student->delete();

        return redirect()->route('students.index')->with('status', 'Student deleted successfully.');
    }
}
