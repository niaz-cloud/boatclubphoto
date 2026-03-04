@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">Teacher Dashboard</h5>
                <small class="text-muted">Overview of your classroom activity</small>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-user-graduate fa-2x text-primary mb-2"></i>
                        <h6>Total Students</h6>
                        <h3 class="fw-bold">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-user-check fa-2x text-success mb-2"></i>
                        <h6>Today's Attendance</h6>
                        <h3 class="fw-bold">{{ $todayAttendance }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-chart-column fa-2x text-warning mb-2"></i>
                        <h6>Total Results</h6>
                        <h3 class="fw-bold">{{ $totalResults }}</h3>
                    </div>
                </div>
            </div>

        </div>


        {{-- Chart + Quick Info --}}
        <div class="row mb-4">

            {{-- Student Activity Chart --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Student Activity Overview</h6>
                    </div>

                    <div class="card-body">
                        <canvas id="teacherChart"></canvas>
                    </div>
                </div>
            </div>


            {{-- Quick Info --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Quick Info</h6>
                    </div>

                    <div class="card-body">

                        <p><strong>Total Students:</strong> {{ $totalStudents }}</p>

                        <p><strong>Today's Attendance:</strong> {{ $todayAttendance }}</p>

                        <p><strong>Total Results:</strong> {{ $totalResults }}</p>

                        <p class="text-muted">
                            Manage students, attendance, and results from the sidebar.
                        </p>

                    </div>
                </div>
            </div>

        </div>


        {{-- Students Table --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">My Assigned Students</h6>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Roll</th>
                                <th>Class</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->roll_number }}</td>
                                    <td>{{ $student->class->class_name ?? '-' }}</td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No students assigned
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- Chart Script --}}
    <script>
        const ctx = document.getElementById('teacherChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Students', 'Attendance Today', 'Results'],
                datasets: [{
                    label: 'Teacher Data',
                    data: [
                        {{ $totalStudents }},
                        {{ $todayAttendance }},
                        {{ $totalResults }}
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
