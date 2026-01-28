@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="fw-bold">Welcome to Student Dashboard</h5>
        </div>
    </div>

    <div class="row">

        {{-- Total Students --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#2563eb;">
                <div class="card-body">
                    <h6 class="text-uppercase">Total Students</h6>
                    <h2 class="fw-bold">{{ $data['total_students'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

      {{-- Exams --}}
<div class="col-md-3 grid-margin stretch-card">
    <div class="card text-white" style="background:#dc2626;">
        <div class="card-body">
            <h6 class="text-uppercase">Exams</h6>
            <h2 class="fw-bold">{{ $data['total_exams'] ?? 0 }}</h2>

            <div class="mt-2">
                <a href="{{ url('/admin/exams') }}" class="text-white text-decoration-none">
                    View Exams <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>


        {{-- Total Classes --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#9333ea;">
                <div class="card-body">
                    <h6 class="text-uppercase">Classes</h6>
                    <h2 class="fw-bold">{{ $data['total_classes'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Total Teachers --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#f97316;">
                <div class="card-body">
                    <h6 class="text-uppercase">Teachers</h6>
                    <h2 class="fw-bold">{{ $data['total_teachers'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        {{-- Today Attendance --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Today Attendance</h6>

                    <p class="mb-2">
                        Present: <strong>{{ $data['present_today'] ?? 0 }}</strong>
                    </p>
                    <p class="mb-0">
                        Absent: <strong>{{ $data['absent_today'] ?? 0 }}</strong>
                    </p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Quick Actions</h6>

                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ url('/admin/students/add') }}">
                                ➤ Add New Student
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/admin/attendance') }}">
                                ➤ Take Attendance
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/results') }}">
                                ➤ Publish Results
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
