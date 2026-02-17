@extends('backend.student.student_layout')

@section('content')
<div class="page-content">

    {{-- ===================== --}}
    {{-- Header / Welcome --}}
    {{-- ===================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Welcome back, {{ auth()->user()->name }} 👋
            </h4>
            <p class="text-muted mb-0">
                Here’s what’s happening with your academics today
            </p>
        </div>

        <div class="text-end">
            <small class="text-muted d-block">
                {{ now()->format('l, d M Y') }}
            </small>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- Summary Statistics --}}
    {{-- ===================== --}}
    <div class="row g-3 mb-4">

        {{-- Total Exams --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Exams</small>
                    <h4 class="fw-bold mb-0">
                        {{ $data['total_exams'] ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- Average Score --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Average Score</small>
                    <h4 class="fw-bold mb-0">
                        {{ $data['avg_score'] ?? '0%' }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- Attendance --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Attendance</small>
                    <h4 class="fw-bold mb-0">
                        {{ $data['attendance'] ?? '0%' }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- Active Class --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Active Class</small>
                    <h6 class="fw-bold mb-0">
                        {{ $data['active_class'] ?? 'N/A' }}
                    </h6>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- Main Action Cards --}}
    {{-- ===================== --}}
    <div class="row g-4">

        {{-- My Results --}}
        <div class="col-md-4">
            <div class="card dashboard-card border-0">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-square-poll-vertical dashboard-icon text-primary"></i>
                    </div>
                    <h6 class="fw-semibold">My Results</h6>
                    <p class="text-muted small mb-3">
                        View your exam performance and scores
                    </p>
                    <a href="{{ route('student.results') }}" class="btn btn-primary btn-sm px-3">
                        View Results
                    </a>
                </div>
            </div>
        </div>

        {{-- My Attendance --}}
        <div class="col-md-4">
            <div class="card dashboard-card border-0">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-calendar-check dashboard-icon text-success"></i>
                    </div>
                    <h6 class="fw-semibold">My Attendance</h6>
                    <p class="text-muted small mb-3">
                        Track your attendance history
                    </p>
                    <a href="{{ route('student.attendance') }}" class="btn btn-success btn-sm px-3">
                        View Attendance
                    </a>
                </div>
            </div>
        </div>

        {{-- My Profile --}}
        <div class="col-md-4">
            <div class="card dashboard-card border-0">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-user dashboard-icon text-secondary"></i>
                    </div>
                    <h6 class="fw-semibold">My Profile</h6>
                    <p class="text-muted small mb-3">
                        Manage and update your information
                    </p>
                    <a href="{{ route('student.profile') }}" class="btn btn-secondary btn-sm px-3">
                        View Profile
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- Recent Activity --}}
    {{-- ===================== --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Recent Activity</h6>

                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 text-muted small">
                            ✅ Latest exam result published
                        </li>
                        <li class="mb-2 text-muted small">
                            📅 Attendance updated
                        </li>
                        <li class="text-muted small">
                            🔔 New notice available
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
