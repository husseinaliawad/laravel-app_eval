<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'permission:dashboard.view'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index')->middleware('permission:analytics.view');
    Route::get('/docs', [DocsController::class, 'index'])->name('docs.index')->middleware('permission:docs.view');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:reports.view');

    Route::resource('students', StudentController::class)->except(['show'])->middleware('permission:students.viewAny');
    Route::resource('courses', CourseController::class)->except(['show'])->middleware('permission:courses.viewAny');
    Route::resource('sections', SectionController::class)->except(['show'])->middleware('permission:sections.viewAny');
    Route::resource('assessments', AssessmentController::class)->except(['show'])->middleware('permission:assessments.viewAny');
    Route::resource('grades', GradeController::class)->except(['show'])->middleware('permission:grades.viewAny');
    Route::resource('attendance', AttendanceController::class)->except(['show'])->middleware('permission:attendance.viewAny');
    Route::resource('kpis', KpiController::class)->except(['show'])->middleware('permission:kpis.viewAny');
});

require __DIR__.'/auth.php';
