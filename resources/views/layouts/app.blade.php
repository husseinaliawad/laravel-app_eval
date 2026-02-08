<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Academic Performance Evaluation Platform') }}</title>

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
                    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                        <span class="brand-mark">APE</span>
                        <span class="fw-semibold">Academic Performance Evaluation Platform</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMain">
                        <div class="ms-auto d-flex align-items-center gap-2">
                            <button id="themeToggle" class="btn btn-sm btn-outline-primary" type="button">
                                <i class="bi bi-moon-stars"></i>
                                <span>Dark</span>
                            </button>
                            <button id="rtlToggle" class="btn btn-sm btn-outline-secondary" type="button">RTL</button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name ?? 'Account' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item" type="submit">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4">
            <div class="container">
                <div class="app-shell">
                    <aside class="app-sidebar">
                        <div class="app-logo">SVU | APE</div>
                        <nav class="app-nav">
                            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Overview</a>
                            @can('students.viewAny')
                                <a class="{{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">Students</a>
                            @endcan
                            @can('courses.viewAny')
                                <a class="{{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Courses</a>
                            @endcan
                            @can('sections.viewAny')
                                <a class="{{ request()->routeIs('sections.*') ? 'active' : '' }}" href="{{ route('sections.index') }}">Sections</a>
                            @endcan
                            @can('assessments.viewAny')
                                <a class="{{ request()->routeIs('assessments.*') ? 'active' : '' }}" href="{{ route('assessments.index') }}">Assessments</a>
                            @endcan
                            @can('grades.viewAny')
                                <a class="{{ request()->routeIs('grades.*') ? 'active' : '' }}" href="{{ route('grades.index') }}">Grades</a>
                            @endcan
                            @can('attendance.viewAny')
                                <a class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">Attendance</a>
                            @endcan
                            @can('kpis.viewAny')
                                <a class="{{ request()->routeIs('kpis.*') ? 'active' : '' }}" href="{{ route('kpis.index') }}">KPI Builder</a>
                            @endcan
                            @can('reports.view')
                                <a class="{{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">Reports</a>
                            @endcan
                            @can('docs.view')
                                <a class="{{ request()->routeIs('docs.*') ? 'active' : '' }}" href="{{ route('docs.index') }}">Docs</a>
                            @endcan
                        </nav>
                        <div class="app-footer">
                            <span class="badge badge-soft-info">{{ auth()->user()?->getRoleNames()->first() ?? 'User' }}</span>
                        </div>
                    </aside>
                    <div class="app-main">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
