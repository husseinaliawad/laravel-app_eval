@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Functional & Non-Functional Requirements</h2>
            <p class="section-subtitle">Structured requirements aligned with governance, analytics, and scalability.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-elevated h-100">
                    <h6>Functional Requirements</h6>
                    <ul class="requirements-list">
                        <li>RBAC for Admin, Instructor, Student, Quality Officer roles.</li>
                        <li>Manage faculties, departments, courses, semesters, and sections.</li>
                        <li>Assessment setup, grades entry, attendance tracking.</li>
                        <li>KPI definition, weighting, and evaluation rules.</li>
                        <li>Analytics dashboards with chart visualizations.</li>
                        <li>Early warning alerts and recommendation engine.</li>
                        <li>Notifications center with targeting and read status.</li>
                        <li>Audit logs for grade edits and KPI changes.</li>
                        <li>Reports export to PDF and Excel.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-elevated h-100">
                    <h6>Non-Functional Requirements</h6>
                    <ul class="requirements-list">
                        <li>Security: hashed passwords, MFA-ready, role isolation.</li>
                        <li>Scalability: modular services and queue-ready jobs.</li>
                        <li>Availability: 99.5% uptime with backups.</li>
                        <li>Performance: dashboards load under 2 seconds.</li>
                        <li>Auditability: immutable logs with actor/time data.</li>
                        <li>Accessibility: WCAG 2.1 AA, RTL support.</li>
                        <li>Compliance: academic data privacy policies.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">User Stories</h2>
            <p class="section-subtitle">Representative stories for each role.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card-elevated h-100">
                    <h6>Admin</h6>
                    <ul class="requirements-list">
                        <li>Assign roles and permissions to protect data.</li>
                        <li>Configure departments and courses.</li>
                        <li>View system-wide KPI dashboards.</li>
                        <li>Review audit logs for compliance.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-elevated h-100">
                    <h6>Instructor</h6>
                    <ul class="requirements-list">
                        <li>Enter grades and attendance quickly.</li>
                        <li>Monitor learning gaps per section.</li>
                        <li>Export reports for advising.</li>
                        <li>Receive alerts on at-risk students.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-elevated h-100">
                    <h6>Student</h6>
                    <ul class="requirements-list">
                        <li>View grades and attendance in one place.</li>
                        <li>Compare anonymously to class averages.</li>
                        <li>Receive improvement recommendations.</li>
                        <li>Track progress toward KPIs.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-elevated h-100">
                    <h6>Quality Officer</h6>
                    <ul class="requirements-list">
                        <li>Analyze program success rates.</li>
                        <li>Detect curriculum gaps.</li>
                        <li>Generate compliance reports.</li>
                        <li>Propose interventions.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Database ERD & SQL Schema</h2>
            <p class="section-subtitle">Normalized schema supporting RBAC, courses, assessments, KPIs, and analytics.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card-elevated h-100">
                    <h6>ERD Description</h6>
                    <pre class="code-block">users -> roles (many-to-many)
roles -> permissions (many-to-many)
faculties -> departments -> courses -> sections
semesters -> sections
sections -> enrollments -> grades -> assessments
sections -> attendance
courses -> kpis -> kpi_rules
users -> notifications
users -> audit_logs</pre>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-elevated h-100">
                    <h6>SQL Schema (Core Tables)</h6>
                    <pre class="code-block">See migrations in database/migrations for full schema.
Primary entities include users, roles, permissions, faculties,
departments, courses, sections, assessments, grades, attendance,
kpis, kpi_rules, notifications, and audit_logs.</pre>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Laravel Backend Architecture</h2>
            <p class="section-subtitle">Clean architecture with service layer, policy authorization, and audit-ready logging.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card-elevated h-100">
                    <h6>Recommended Folder Structure</h6>
                    <pre class="code-block">app/
  Http/
    Controllers/
      Admin/
      Instructor/
      Student/
      Reports/
    Requests/
    Middleware/
  Models/
  Policies/
  Services/
    Analytics/
    KPI/
    Notifications/
    Reports/
  Jobs/
  Events/
  Listeners/
  Observers/
  Notifications/
  Providers/

routes/
  web.php
  api.php
  admin.php
  instructor.php
  student.php</pre>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card-elevated h-100">
                    <h6>Core Components</h6>
                    <ul class="requirements-list">
                        <li>Auth: Laravel Breeze with session guards.</li>
                        <li>Policies: Gate-based checks for RBAC.</li>
                        <li>Services: KPI scoring, early warning logic.</li>
                        <li>Observers: Audit log creation on model updates.</li>
                        <li>Queues: Report generation and notifications.</li>
                        <li>API: REST endpoints for dashboards.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">UI Component Library</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Core Components</h6>
                    <ul class="requirements-list">
                        <li>Sidebar + top navbar</li>
                        <li>KPI cards and stats tiles</li>
                        <li>Data tables with filters</li>
                        <li>Chart widgets</li>
                        <li>Alert banners & badges</li>
                        <li>Modal dialogs and drawers</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Forms & Inputs</h6>
                    <ul class="requirements-list">
                        <li>Multi-step forms</li>
                        <li>Date pickers and range filters</li>
                        <li>Weight sliders and toggles</li>
                        <li>Inline validation states</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Utilities</h6>
                    <ul class="requirements-list">
                        <li>Toast notifications</li>
                        <li>Export buttons</li>
                        <li>Empty state panels</li>
                        <li>Audit log timeline</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Landing Page Content Text</h2>
        </div>
        <div class="card-elevated">
            <pre class="code-block">Headline: Elevate Academic Quality with KPI-Driven Insight
Subheadline: Empower leadership, instructors, and students with real-time analytics, early warnings, and evidence-based decisions.
Primary CTA: Request Demo
Secondary CTA: Download Program Brief
Key Value Points:
- Continuous monitoring of learning outcomes and teaching quality.
- Early warning alerts to prevent student underperformance.
- Role-based dashboards for every stakeholder.
- Exportable reports aligned with accreditation needs.
Social Proof: Trusted by SVU academic leadership and quality assurance teams.</pre>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">5-Month Implementation Timeline</h2>
            <p class="section-subtitle">Weekly milestones, deliverables, testing, and deployment plan.</p>
        </div>
        <div class="card-elevated">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Week</th>
                            <th>Milestone</th>
                            <th>Deliverables</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>Discovery & Scope</td><td>Requirements workshops, KPI inventory, risk register</td></tr>
                        <tr><td>2</td><td>UX Research</td><td>User journeys, persona validation, IA map</td></tr>
                        <tr><td>3</td><td>Wireframes</td><td>Low-fidelity wireframes for all pages</td></tr>
                        <tr><td>4</td><td>Visual Design</td><td>Design system, UI kit, RTL guidelines</td></tr>
                        <tr><td>5</td><td>Front-end Setup</td><td>Bootstrap theme, layout scaffolding</td></tr>
                        <tr><td>6</td><td>Auth & RBAC</td><td>Laravel Breeze/Fortify, roles & permissions</td></tr>
                        <tr><td>7</td><td>Core Data Models</td><td>Migrations for courses, sections, semesters</td></tr>
                        <tr><td>8</td><td>Assessments</td><td>Assessment builder, grade entry UI</td></tr>
                        <tr><td>9</td><td>Attendance</td><td>Attendance service and alerts</td></tr>
                        <tr><td>10</td><td>KPI Engine</td><td>KPI scoring, rule evaluation service</td></tr>
                        <tr><td>11</td><td>Dashboards</td><td>Role-based dashboards, summary cards</td></tr>
                        <tr><td>12</td><td>Analytics</td><td>Chart.js reports, filters, export hooks</td></tr>
                        <tr><td>13</td><td>Notifications</td><td>Notification center, email/SMS hooks</td></tr>
                        <tr><td>14</td><td>Audit Logs</td><td>Observer-based audit tracking</td></tr>
                        <tr><td>15</td><td>QA Testing</td><td>Unit tests, feature tests, security review</td></tr>
                        <tr><td>16</td><td>Performance</td><td>Caching strategy, query optimization</td></tr>
                        <tr><td>17</td><td>UAT</td><td>Stakeholder validation, feedback loop</td></tr>
                        <tr><td>18</td><td>Deployment Prep</td><td>CI/CD pipeline, backup strategy</td></tr>
                        <tr><td>19</td><td>Pilot Launch</td><td>Limited rollout, monitoring dashboards</td></tr>
                        <tr><td>20</td><td>Final Release</td><td>Documentation, handover, final report</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Task Distribution</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Banan (Frontend + UI + Diagrams + Report)</h6>
                    <ul class="requirements-list">
                        <li>Design system, landing page, dashboards.</li>
                        <li>Wireframes, ERD diagrams, UI kit.</li>
                        <li>Frontend documentation and report visuals.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Tarek (Frontend + Backend + Report)</h6>
                    <ul class="requirements-list">
                        <li>Laravel controllers, routes, and APIs.</li>
                        <li>Frontend integration with charts and tables.</li>
                        <li>Reporting exports and KPI dashboard logic.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-elevated h-100">
                    <h6>Ghufran (Backend + Database + Testing + Report)</h6>
                    <ul class="requirements-list">
                        <li>Database schema, migrations, seeders.</li>
                        <li>Testing strategy and QA documentation.</li>
                        <li>Audit logs, permissions, and security.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Hosting Notes</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-elevated h-100">
                    <h6>InfinityFree</h6>
                    <ul class="requirements-list">
                        <li>Suitable for static demo or lightweight Laravel.</li>
                        <li>Upload public folder contents and configure .htaccess.</li>
                        <li>MySQL available with limited storage.</li>
                        <li>Use queue sync driver and disable heavy jobs.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-elevated h-100">
                    <h6>Firebase + Laravel</h6>
                    <ul class="requirements-list">
                        <li>Host front-end on Firebase Hosting.</li>
                        <li>Deploy Laravel API on VPS/Render and connect via REST.</li>
                        <li>Use Firebase Storage for report files.</li>
                        <li>Configure CORS and HTTPS for secure API calls.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
