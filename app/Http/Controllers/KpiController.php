<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKpiRequest;
use App\Http\Requests\UpdateKpiRequest;
use App\Models\Course;
use App\Models\Kpi;

class KpiController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Kpi::class);

        $kpis = Kpi::with('course')->paginate(10);
        return view('kpis.index', compact('kpis'));
    }

    public function create()
    {
        $this->authorize('create', Kpi::class);

        $courses = Course::orderBy('title')->get();
        return view('kpis.create', compact('courses'));
    }

    public function store(StoreKpiRequest $request)
    {
        $this->authorize('create', Kpi::class);

        Kpi::create($request->validated());
        return redirect()->route('kpis.index')->with('status', 'KPI created successfully.');
    }

    public function edit(Kpi $kpi)
    {
        $this->authorize('update', $kpi);

        $courses = Course::orderBy('title')->get();
        return view('kpis.edit', compact('kpi', 'courses'));
    }

    public function update(UpdateKpiRequest $request, Kpi $kpi)
    {
        $this->authorize('update', $kpi);

        $kpi->update($request->validated());
        return redirect()->route('kpis.index')->with('status', 'KPI updated successfully.');
    }

    public function destroy(Kpi $kpi)
    {
        $this->authorize('delete', $kpi);

        $kpi->delete();
        return redirect()->route('kpis.index')->with('status', 'KPI deleted successfully.');
    }
}
