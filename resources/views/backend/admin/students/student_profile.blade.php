@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Student Profile</h5>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
            ← Back to List
        </a>
    </div>

    {{-- ================= BASIC INFO ================= --}}
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="fw-semibold mb-2">{{ $student->name }}</h6>

            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><b>Roll:</b> {{ $student->roll_number }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1">
                        <b>Class:</b>
                        {{ $student->class->class_name ?? '-' }}
                        {{ $student->class->section ?? '' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><b>Phone:</b> {{ $student->phone ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ATTENDANCE SUMMARY ================= --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <small class="text-muted">Attendance %</small>
                    <h3 class="fw-bold text-primary">{{ $percentage }}%</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <small class="text-muted">Present</small>
                    <h4 class="fw-bold text-success">{{ $present }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <small class="text-muted">Late</small>
                    <h4 class="fw-bold text-warning">{{ $late }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <small class="text-muted">Absent</small>
                    <h4 class="fw-bold text-danger">{{ $absent }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= RECENT ATTENDANCE ================= --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Recent Attendance</h6>

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
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
                                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $badge = match($row->status) {
                                            'present' => 'bg-success',
                                            'late'    => 'bg-warning',
                                            'absent'  => 'bg-danger',
                                            default   => 'bg-secondary',
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
                                <td colspan="3" class="text-center text-muted">
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
    <div class="card">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Exam Results</h6>

            @if($student->results->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
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
                                            <span class="badge bg-success">Pass</span>
                                        @else
                                            <span class="badge bg-danger">Fail</span>
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
