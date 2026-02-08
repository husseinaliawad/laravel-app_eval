<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Kpi;
use App\Models\Section;
use App\Models\User;
use App\Policies\AssessmentPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\CoursePolicy;
use App\Policies\GradePolicy;
use App\Policies\KpiPolicy;
use App\Policies\SectionPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => StudentPolicy::class,
        Course::class => CoursePolicy::class,
        Section::class => SectionPolicy::class,
        Assessment::class => AssessmentPolicy::class,
        Grade::class => GradePolicy::class,
        Attendance::class => AttendancePolicy::class,
        Kpi::class => KpiPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
