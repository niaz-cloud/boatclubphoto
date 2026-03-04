@extends('backend.admin.includes.admin_layout')

@section('content')
    <h4 class="mb-4">Add Attendance</h4>

    <form action="{{ route('teacher.attendance.store') }}" method="POST">
        @csrf

        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Save Attendance
        </button>

    </form>
@endsection
