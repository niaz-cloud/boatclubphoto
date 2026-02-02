@extends('backend.operator.includes.operator_layout')

@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <h6 class="card-title mb-3">Welcome To Dashboard</h6>

            {{-- Optional Debug Output --}}
            {{-- <pre>{{ json_encode($data['students_per_class'] ?? null) }}</pre> --}}

            <div class="row">

                {{-- Total Students --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Students</h6>
                            </div>

                            <div class="mt-2" style="color: green; font-size:18px">
                                {{ $data['total_student'] }}
                            </div>

                            <div class="mt-2">
                                <a href="">
                                    Student List <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Students Per Class Chart --}}
                <div class="col-md-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Students Per Class</h6>
                          <canvas id="studentsPieChart" height="300" style="width:100%; max-height:300px;"></canvas>

                        </div>
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
window.addEventListener('load', function () {
    const canvas = document.getElementById('studentsPieChart');
    if (!canvas) return;

    const labels = {!! json_encode($data['students_per_class']->keys()) !!};
    const values = {!! json_encode($data['students_per_class']->values()) !!};

    if (!labels.length || !values.length) {
        console.warn('No pie chart data available');
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
