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

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#2563eb;">
                <div class="card-body">
                    <h6>Total Students</h6>
                    <h2 class="fw-bold">{{ $data['total_students'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#dc2626;">
                <div class="card-body">
                    <h6>Exams</h6>
                    <h2 class="fw-bold">{{ $data['total_exams'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#9333ea;">
                <div class="card-body">
                    <h6>Classes</h6>
                    <h2 class="fw-bold">{{ $data['total_classes'] }}</h2>
                    <small>Active: {{ $data['active_classes'] }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card text-white" style="background:#16a34a;">
                <div class="card-body">
                    <h6>Results</h6>
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

                    <table class="table table-sm">
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
                                        No data found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- Pie Chart --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Students Per Class</h6>

                    <div style="height:300px;">
                        <canvas id="studentsPieChart"></canvas>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- THIRD ROW --}}
    <div class="row mt-3">

        {{-- Attendance Bar Chart --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Attendance Per Class</h6>

                    <div style="height:300px;">
                        <canvas id="attendanceBarChart"></canvas>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // -------------------------
    // PIE CHART: students_per_class (key => value)
    // -------------------------
    const pieCanvas = document.getElementById('studentsPieChart');
    if (pieCanvas) {
        const labels = {!! json_encode($data['students_per_class']->keys()) !!};
        const values = {!! json_encode($data['students_per_class']->values()) !!};

        if (labels.length && values.length) {
            new Chart(pieCanvas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#2563eb', '#dc2626', '#9333ea',
                            '#16a34a', '#facc15', '#3b82f6',
                            '#ec4899', '#22c55e', '#a855f7'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        } else {
            console.warn('No data for Students Pie Chart');
        }
    }

    // -------------------------
    // BAR CHART: attendance_per_class (list of objects)
    // [{class_name: "...", total_attendance: 123}, ...]
    // -------------------------
    const barCanvas = document.getElementById('attendanceBarChart');
    if (barCanvas) {
        const attendanceData = @json($data['attendance_per_class']);

        const barLabels = attendanceData.map(x => x.class_name);
        const barValues = attendanceData.map(x => x.total_attendance);

        if (barLabels.length && barValues.length) {
            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Present Count',
                        data: barValues,
                        backgroundColor: '#3b82f6',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        } else {
            console.warn('No data for Attendance Bar Chart');
        }
    }

});
</script>
@endpush
