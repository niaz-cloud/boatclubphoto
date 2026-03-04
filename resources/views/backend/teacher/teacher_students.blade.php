@extends('backend.admin.includes.admin_layout')

@section('content')
    <h4 class="mb-4">My Students</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Roll</th>
                <th>Class</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->roll_number }}</td>
                    <td>{{ $student->class->class_name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-sm btn-primary">View</a>

                        <a href="{{ route('teacher.attendance.create', $student->id) }}"
                            class="btn btn-sm btn-success">Attendance</a>

                        <a href="{{ route('teacher.results.create', $student->id) }}"
                            class="btn btn-sm btn-warning">Result</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
