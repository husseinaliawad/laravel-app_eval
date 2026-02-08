<!doctype html>
<html lang="en" data-theme="light" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Academic Performance Evaluation Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link id="bootstrapLtr" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link id="bootstrapRtl" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet" disabled>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page-bg"></div>
    <header class="sticky-top border-bottom glass-nav">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                    <span class="brand-mark">APE</span>
                    <span class="fw-semibold">Academic Performance Evaluation Platform</span>
                </a>
                <div class="ms-auto d-flex gap-2">
                    @auth
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-sm btn-primary" href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <p class="eyebrow">Syrian Virtual University | Ministry of Higher Education - Syrian Arab Republic</p>
                        <h1 class="display-5 fw-bold">Academic Performance Evaluation Platform</h1>
                        <p class="lead text-muted">A production-grade, KPI-driven platform that empowers academic leaders, instructors, and students with continuous performance intelligence, early warning alerts, and data-driven quality improvement.</p>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Request Demo</a>
                            <a class="btn btn-outline-primary btn-lg" href="{{ route('docs.index') }}">Download Brief</a>
                        </div>
                        <div class="hero-meta mt-4">
                            <div>
                                <span class="meta-label">Course</span>
                                <strong>ITE_BPR601_F24</strong>
                            </div>
                            <div>
                                <span class="meta-label">Instructor</span>
                                <strong>Dr. Mohammad Al-Shayta</strong>
                            </div>
                            <div>
                                <span class="meta-label">Students</span>
                                <strong>Ghufran_267526 | Banan_154555 | Tarek_152929</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-card card-elevated" data-reveal>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-uppercase text-muted small mb-1">KPI Attainment</p>
                                    <h3 class="fw-semibold mb-0">86.4%</h3>
                                </div>
                                <span class="badge badge-soft-success">+6.2% QoQ</span>
                            </div>
                            <div class="progress mb-3" role="progressbar" aria-label="KPI attainment">
                                <div class="progress-bar" style="width: 86%"></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card">
                                        <span class="text-muted small">At-Risk Students</span>
                                        <h5 class="mb-0">14</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <span class="text-muted small">Avg Attendance</span>
                                        <h5 class="mb-0">88.2%</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <span class="text-muted small">Active Courses</span>
                                        <h5 class="mb-0">42</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <span class="text-muted small">Feedback Score</span>
                                        <h5 class="mb-0">4.6 / 5</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                <small class="text-muted">Last refresh: <span id="refreshTime">just now</span></small>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">View Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
