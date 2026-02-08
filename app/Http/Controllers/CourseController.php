<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::with('department')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        $departments = Department::orderBy('name')->get();
        return view('courses.create', compact('departments'));
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        Course::create($request->validated());
        return redirect()->route('courses.index')->with('status', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $departments = Department::orderBy('name')->get();
        return view('courses.edit', compact('course', 'departments'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course->update($request->validated());
        return redirect()->route('courses.index')->with('status', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return redirect()->route('courses.index')->with('status', 'Course deleted successfully.');
    }
}
