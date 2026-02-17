@extends('backend.student.student_layout')

@section('content')

{{-- ===================== --}}
{{-- Page Level CSS --}}
{{-- ===================== --}}
<style>

    .summary-card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: none;
    }

    .summary-card small {
        font-size: 12px;
        color: #6b7280;
    }

    .summary-card h4 {
        font-weight: 700;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .dashboard-card {
        border-radius: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: none;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .table {
        font-size: 14px;
    }

    .table thead th {
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }

    .badge {
        border-radius: 8px;
        font-weight: 500;
        font-size: 12px;
        padding: 6px 10px;
    }

</style>

<div class="page-content">

    {{-- ===================== --}}
    {{-- Header --}}
    {{-- ===================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">📅 My Attendance</h4>
            <p class="text-muted mb-0">
                Track your attendance history and participation
            </p>
        </div>

        <div class="text-end">
            <small class="text-muted">
                {{ now()->format('l, d M Y') }}
            </small>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- Summary Cards --}}
    {{-- ===================== --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Total Classes</small>
                    <h4>{{ $attendance->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Present</small>
                    <h4 class="text-success">
                        {{ $attendance->where('status', 'present')->count() }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Absent</small>
                    <h4 class="text-danger">
                        {{ $attendance->where('status', 'absent')->count() }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- Attendance Table --}}
    {{-- ===================== --}}
    <div class="card dashboard-card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($attendance as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                    </span>
                                </td>

                                <td>
                                    @if($row->status == 'present')
                                        <span class="badge bg-success-subtle text-success">
                                            ✅ Present
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            ❌ Absent
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    No attendance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
