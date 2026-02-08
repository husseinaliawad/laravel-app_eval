<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Models\Assessment;
use App\Models\Course;

class AssessmentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Assessment::class);

        $assessments = Assessment::with('course')->paginate(10);
        return view('assessments.index', compact('assessments'));
    }

    public function create()
    {
        $this->authorize('create', Assessment::class);

        $courses = Course::orderBy('title')->get();
        return view('assessments.create', compact('courses'));
    }

    public function store(StoreAssessmentRequest $request)
    {
        $this->authorize('create', Assessment::class);

        Assessment::create($request->validated());
        return redirect()->route('assessments.index')->with('status', 'Assessment created successfully.');
    }

    public function edit(Assessment $assessment)
    {
        $this->authorize('update', $assessment);

        $courses = Course::orderBy('title')->get();
        return view('assessments.edit', compact('assessment', 'courses'));
    }

    public function update(UpdateAssessmentRequest $request, Assessment $assessment)
    {
        $this->authorize('update', $assessment);

        $assessment->update($request->validated());
        return redirect()->route('assessments.index')->with('status', 'Assessment updated successfully.');
    }

    public function destroy(Assessment $assessment)
    {
        $this->authorize('delete', $assessment);

        $assessment->delete();
        return redirect()->route('assessments.index')->with('status', 'Assessment deleted successfully.');
    }
}
