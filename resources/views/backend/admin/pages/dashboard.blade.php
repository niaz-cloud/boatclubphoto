@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Welcome --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="fw-bold">Welcome to Student Information System (SIS)</h5>
            <small class="text-muted">Overview of academic data</small>
        </div>
    </div>

    {{-- TOP STATS --}}
    <div class="row">

        {{-- Total Students --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#2563eb;">
                <div class="card-body">
                    <h6 class="text-uppercase">Total Students</h6>
                    <h2 class="fw-bold">{{ $data['total_students'] }}</h2>
                </div>
            </div>
        </div>

        {{-- Total Exams --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#dc2626;">
                <div class="card-body">
                    <h6 class="text-uppercase">Exams</h6>
                    <h2 class="fw-bold">{{ $data['total_exams'] }}</h2>

                    <div class="mt-2">
                        <a href="{{ route('admin.exams.index') }}" class="text-white text-decoration-none">
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
                    <h2 class="fw-bold">{{ $data['total_classes'] }}</h2>
                    <small class="d-block">
                        Active: {{ $data['active_classes'] }}
                    </small>
                </div>
            </div>
        </div>

        {{-- Total Results --}}
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#16a34a;">
                <div class="card-body">
                    <h6 class="text-uppercase">Results</h6>
                    <h2 class="fw-bold">{{ $data['total_results'] }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- SECOND ROW --}}
    <div class="row mt-3">

        {{-- Recent Classes --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Recent Classes</h6>

                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['recent_classes'] as $class)
                                <tr>
                                    <td>{{ $class->class_name }}</td>
                                    <td>{{ $class->section ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $class->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $class->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No classes found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Quick Actions</h6>

                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('admin.students.index') }}">
                                ➤ Manage Students
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.classes.index') }}">
                                ➤ Manage Classes
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.results.index') }}">
                                ➤ View Results
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.exams.index') }}">
                                ➤ Manage Exams
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
