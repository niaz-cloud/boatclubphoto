@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h5 class="mb-0 fw-semibold">Edit Attendance</h5>

        <a href="{{ route('admin.attendance.index', ['date' => $attendance->date, 'class_id' => $attendance->class_id]) }}"
           class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <p class="mb-2">
                <b>Date:</b> {{ $attendance->date }}
                | <b>Student ID:</b> {{ $attendance->student_id }}
                | <b>Class ID:</b> {{ $attendance->class_id }}
            </p>

            <form method="POST" action="{{ route('admin.attendance.update', $attendance->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent"  {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                    </select>
                </div>

                <button class="btn btn-primary px-4">Update</button>
            </form>

        </div>
    </div>

</div>
@endsection
