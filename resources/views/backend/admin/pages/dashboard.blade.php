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
                                    <td colspan="3" class="text-center text-muted">No data found</td>
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
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Attendance Per Class</h6>
                    <div style="height:320px;">
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

    // PIE CHART
    const pieCanvas = document.getElementById('studentsPieChart');
    if (pieCanvas) {
        const labels = {!! json_encode($data['students_per_class']->keys()) !!};
        const values = {!! json_encode($data['students_per_class']->values()) !!};

        new Chart(pieCanvas.getContext('2d'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        '#2563eb','#dc2626','#9333ea',
                        '#16a34a','#facc15','#3b82f6'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // BAR CHART
    const barCanvas = document.getElementById('attendanceBarChart');
    if (barCanvas) {
        const data = @json($data['attendance_per_class']);

        const labels = data.map(x => x.class_name);
        const values = data.map(x => x.total_attendance);

        new Chart(barCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    }

});
</script>
@endpush
