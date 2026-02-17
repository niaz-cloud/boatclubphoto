@extends('backend.student.student_layout')

@section('content')

{{-- ===================== --}}
{{-- Page Level CSS --}}
{{-- ===================== --}}
<style>

    .dashboard-card {
        border-radius: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: none;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

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
    }

</style>

<div class="page-content">

    {{-- ===================== --}}
    {{-- Header --}}
    {{-- ===================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">📊 My Results</h4>
            <p class="text-muted mb-0">
                Review your academic performance and exam outcomes
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

        <div class="col-md-3">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Exams Taken</small>
                    <h4>{{ $results->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Average Marks</small>
                    <h4>{{ number_format($results->avg('obtained_mark') ?? 0, 1) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Passed</small>
                    <h4 class="text-success">
                        {{ $results->where('status', 'pass')->count() }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card">
                <div class="card-body">
                    <small>Failed</small>
                    <h4 class="text-danger">
                        {{ $results->where('status', 'fail')->count() }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- Results Table --}}
    {{-- ===================== --}}
    <div class="card dashboard-card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Exam</th>
                            <th>Marks</th>
                            <th>Pass Mark</th>
                            <th>Percentage</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if($result->exam)
                                        <span class="fw-semibold">
                                            {{ $result->exam->name ?? 'N/A' }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ number_format($result->obtained_mark, 2) }}
                                    </span>
                                    <span class="text-muted">
                                        / {{ number_format($result->total_mark, 2) }}
                                    </span>
                                </td>

                                <td>
                                    {{ number_format($result->pass_mark, 2) }}
                                </td>

                                <td>
                                    @php
                                        $percentage = $result->total_mark > 0
                                            ? ($result->obtained_mark / $result->total_mark) * 100
                                            : 0;
                                    @endphp

                                    <span class="fw-semibold">
                                        {{ number_format($percentage, 1) }}%
                                    </span>
                                </td>

                                <td>
                                    @if($result->status === 'pass')
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            ✅ Pass
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                            ❌ Fail
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No results found
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
