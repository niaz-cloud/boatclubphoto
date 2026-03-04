@extends('backend.admin.includes.admin_layout')
@section('content')
    <h4 class="mb-4">Student Profile</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Roll:</strong> {{ $student->roll_number }}</p>
            <p><strong>Class:</strong> {{ $student->class->class_name ?? '-' }}</p>
            <p><strong>Phone:</strong> {{ $student->phone ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('teacher.attendance.create', $student->id) }}" class="btn btn-success">Add Attendance</a>

    <a href="{{ route('teacher.results.create', $student->id) }}" class="btn btn-warning">Add Result</a>
@endsection
