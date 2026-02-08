<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Grade;
use App\Models\Kpi;
use App\Models\KpiRule;
use App\Models\Notification;
use App\Models\Section;
use App\Models\Semester;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facultyInf = Faculty::create([
            'name' => 'Faculty of Informatics',
            'code' => 'INF',
            'description' => 'Programs in computer science and information systems.',
        ]);
        $facultyBiz = Faculty::create([
            'name' => 'Faculty of Business',
            'code' => 'BUS',
            'description' => 'Business administration and management programs.',
        ]);

        $deptCs = Department::create([
            'faculty_id' => $facultyInf->id,
            'name' => 'Computer Science',
            'code' => 'CS',
        ]);
        $deptIs = Department::create([
            'faculty_id' => $facultyInf->id,
            'name' => 'Information Systems',
            'code' => 'IS',
        ]);
        $deptBiz = Department::create([
            'faculty_id' => $facultyBiz->id,
            'name' => 'Business Administration',
            'code' => 'BA',
        ]);

        $spring = Semester::create([
            'name' => 'Spring 2026',
            'start_date' => '2026-02-01',
            'end_date' => '2026-06-30',
            'status' => 'active',
        ]);

        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@ape.test',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $admin->assignRole('Admin');

        $quality = User::create([
            'name' => 'Quality Officer',
            'email' => 'quality@ape.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'department_id' => $deptCs->id,
        ]);
        $quality->assignRole('QualityOfficer');

        $instructor1 = User::create([
            'name' => 'Dr. Mohammad Al-Shayta',
            'email' => 'instructor1@ape.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'department_id' => $deptCs->id,
        ]);
        $instructor1->assignRole('Instructor');

        $instructor2 = User::create([
            'name' => 'Dr. Lina Haddad',
            'email' => 'instructor2@ape.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'department_id' => $deptBiz->id,
        ]);
        $instructor2->assignRole('Instructor');

        $students = collect([
            ['name' => 'Ghufran_267526', 'email' => 'ghufran@ape.test', 'department_id' => $deptCs->id],
            ['name' => 'Banan_154555', 'email' => 'banan@ape.test', 'department_id' => $deptIs->id],
            ['name' => 'Tarek_152929', 'email' => 'tarek@ape.test', 'department_id' => $deptCs->id],
            ['name' => 'Rama Al-Sayed', 'email' => 'rama@ape.test', 'department_id' => $deptBiz->id],
            ['name' => 'Hala N.', 'email' => 'hala@ape.test', 'department_id' => $deptBiz->id],
            ['name' => 'Omar D.', 'email' => 'omar@ape.test', 'department_id' => $deptCs->id],
        ])->map(function ($data, $index) {
            $student = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'status' => 'active',
                'student_number' => 'SVU-' . str_pad((string) (2100 + $index), 4, '0', STR_PAD_LEFT),
                'department_id' => $data['department_id'],
            ]);
            $student->assignRole('Student');
            return $student;
        });

        $courses = [
            Course::create([
                'department_id' => $deptCs->id,
                'code' => 'CS301',
                'title' => 'Data Mining',
                'credits' => 3,
                'level' => 'Undergraduate',
            ]),
            Course::create([
                'department_id' => $deptCs->id,
                'code' => 'CS315',
                'title' => 'AI Systems',
                'credits' => 3,
                'level' => 'Undergraduate',
            ]),
            Course::create([
                'department_id' => $deptBiz->id,
                'code' => 'BA210',
                'title' => 'Organizational Behavior',
                'credits' => 3,
                'level' => 'Undergraduate',
            ]),
        ];

        $sections = [
            Section::create([
                'course_id' => $courses[0]->id,
                'semester_id' => $spring->id,
                'instructor_id' => $instructor1->id,
                'section_code' => 'A',
                'capacity' => 35,
                'schedule' => 'Sun/Tue 10:00-11:30',
                'location' => 'Room 101',
            ]),
            Section::create([
                'course_id' => $courses[1]->id,
                'semester_id' => $spring->id,
                'instructor_id' => $instructor1->id,
                'section_code' => 'B',
                'capacity' => 30,
                'schedule' => 'Mon/Wed 12:00-13:30',
                'location' => 'Room 202',
            ]),
            Section::create([
                'course_id' => $courses[2]->id,
                'semester_id' => $spring->id,
                'instructor_id' => $instructor2->id,
                'section_code' => 'A',
                'capacity' => 40,
                'schedule' => 'Sun/Tue 14:00-15:30',
                'location' => 'Room 303',
            ]),
        ];

        $assessments = collect($courses)->flatMap(function ($course) {
            return [
                Assessment::create([
                    'course_id' => $course->id,
                    'title' => 'Midterm Exam',
                    'type' => 'Exam',
                    'weight' => 30,
                    'max_score' => 100,
                    'due_date' => '2026-03-15',
                ]),
                Assessment::create([
                    'course_id' => $course->id,
                    'title' => 'Final Exam',
                    'type' => 'Exam',
                    'weight' => 40,
                    'max_score' => 100,
                    'due_date' => '2026-06-15',
                ]),
                Assessment::create([
                    'course_id' => $course->id,
                    'title' => 'Project',
                    'type' => 'Project',
                    'weight' => 30,
                    'max_score' => 100,
                    'due_date' => '2026-05-20',
                ]),
            ];
        });

        $enrollments = [];
        foreach ($students as $student) {
            foreach ($sections as $section) {
                $enrollments[] = Enrollment::create([
                    'section_id' => $section->id,
                    'student_id' => $student->id,
                    'status' => 'active',
                    'enrolled_at' => '2026-02-05',
                ]);
            }
        }

        foreach ($enrollments as $enrollment) {
            $courseAssessments = $assessments->where('course_id', $enrollment->section->course_id);
            foreach ($courseAssessments as $assessment) {
                $score = rand(45, 98);
                Grade::create([
                    'enrollment_id' => $enrollment->id,
                    'assessment_id' => $assessment->id,
                    'score' => $score,
                    'graded_by' => $enrollment->section->instructor_id,
                    'graded_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }

            for ($i = 0; $i < 4; $i++) {
                Attendance::create([
                    'enrollment_id' => $enrollment->id,
                    'attendance_date' => Carbon::parse('2026-02-10')->addDays($i * 7),
                    'status' => ['present', 'late', 'absent'][rand(0, 2)],
                    'recorded_by' => $enrollment->section->instructor_id,
                ]);
            }
        }

        foreach ($courses as $course) {
            $kpi = Kpi::create([
                'course_id' => $course->id,
                'name' => 'Learning Outcome Attainment',
                'weight' => 30,
                'target' => 75,
                'status' => 'active',
            ]);

            KpiRule::create([
                'kpi_id' => $kpi->id,
                'rule_expression' => 'KPI < 70%',
                'severity' => 'high',
                'is_active' => true,
            ]);
        }

        $atRiskStudent = $students->first();
        Notification::create([
            'user_id' => $atRiskStudent->id,
            'title' => 'Early Warning: Performance Risk',
            'body' => 'Your current grade or attendance is below the threshold. Please contact your advisor.',
            'severity' => 'danger',
        ]);
    }
}
