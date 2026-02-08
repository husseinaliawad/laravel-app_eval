<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\Semester;
use App\Models\User;

class SectionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Section::class);

        $sections = Section::with(['course', 'semester', 'instructor'])->paginate(10);
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $this->authorize('create', Section::class);

        $courses = Course::orderBy('title')->get();
        $semesters = Semester::orderBy('start_date', 'desc')->get();
        $instructors = User::role('Instructor')->orderBy('name')->get();

        return view('sections.create', compact('courses', 'semesters', 'instructors'));
    }

    public function store(StoreSectionRequest $request)
    {
        $this->authorize('create', Section::class);

        Section::create($request->validated());
        return redirect()->route('sections.index')->with('status', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        $this->authorize('update', $section);

        $courses = Course::orderBy('title')->get();
        $semesters = Semester::orderBy('start_date', 'desc')->get();
        $instructors = User::role('Instructor')->orderBy('name')->get();

        return view('sections.edit', compact('section', 'courses', 'semesters', 'instructors'));
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $this->authorize('update', $section);

        $section->update($request->validated());
        return redirect()->route('sections.index')->with('status', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $this->authorize('delete', $section);

        $section->delete();
        return redirect()->route('sections.index')->with('status', 'Section deleted successfully.');
    }
}
