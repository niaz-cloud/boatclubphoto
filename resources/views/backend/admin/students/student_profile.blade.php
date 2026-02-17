@extends('backend.admin.includes.admin_layout')

@section('content')

<style>

    .profile-card {
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        border: none;
    }

    .profile-card:hover {
        box-shadow: 0 10px 28px rgba(0,0,0,0.12);
    }

    .stat-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card small {
        font-size: 12px;
        color: #6b7280;
    }

    .stat-card h3, 
    .stat-card h4 {
        font-weight: 700;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .table {
        font-size: 14px;
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }

    .badge {
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        padding: 6px 10px;
    }

</style>

<div class="page-content">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">👤 Student Profile</h4>
            <p class="text-muted mb-0">
                Detailed academic & attendance overview
            </p>
        </div>

        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
            ← Back to List
        </a>
    </div>

    {{-- ================= BASIC INFO ================= --}}
    <div class="card profile-card mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">{{ $student->name }}</h5>

            <div class="row">
                <div class="col-md-4">
                    <small class="text-muted">Roll Number</small>
                    <p class="fw-semibold mb-2">{{ $student->roll_number }}</p>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Class</small>
                    <p class="fw-semibold mb-2">
                        {{ $student->class->class_name ?? '-' }}
                        {{ $student->class->section ?? '' }}
                    </p>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Phone</small>
                    <p class="fw-semibold mb-2">{{ $student->phone ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= ATTENDANCE SUMMARY ================= --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <small>Attendance %</small>
                    <h3 class="text-primary">{{ $percentage }}%</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <small>Present</small>
                    <h4 class="text-success">{{ $present }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <small>Late</small>
                    <h4 class="text-warning">{{ $late }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <small>Absent</small>
                    <h4 class="text-danger">{{ $absent }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= RECENT ATTENDANCE ================= --}}
    <div class="card profile-card mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">📅 Recent Attendance</h6>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Marked Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentAttendance as $row)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                </td>

                                <td>
                                    @php
                                        $badge = match($row->status) {
                                            'present' => 'bg-success-subtle text-success',
                                            'late'    => 'bg-warning-subtle text-warning',
                                            'absent'  => 'bg-danger-subtle text-danger',
                                            default   => 'bg-secondary-subtle text-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>

                                <td>{{ $row->created_at->format('h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No attendance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- ================= EXAM RESULTS ================= --}}
    <div class="card profile-card">
        <div class="card-body">
            <h6 class="fw-bold mb-3">📊 Exam Results</h6>

            @if($student->results->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Exam</th>
                                <th>Marks</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($student->results as $result)
                                <tr>
                                    <td>
                                        {{ $result->exam->name ?? 'Exam #' . $result->exam_id }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $result->obtained_mark }} / {{ $result->total_mark }}
                                    </td>

                                    <td>
                                        @if($result->status === 'pass')
                                            <span class="badge bg-success-subtle text-success">
                                                ✅ Pass
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">
                                                ❌ Fail
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No exam results available.</p>
            @endif
        </div>
    </div>

</div>
@endsection
