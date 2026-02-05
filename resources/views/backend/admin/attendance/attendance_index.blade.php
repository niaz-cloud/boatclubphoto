@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
            <h5 class="mb-0 fw-semibold">Attendance List</h5>
            <small class="text-muted">Filter by date and class</small>
        </div>

        <a href="{{ route('admin.attendance.create') }}" class="btn btn-success btn-sm px-3">
            + Mark Attendance
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <form class="row g-2 mb-3" method="GET" action="{{ route('admin.attendance.index') }}">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>

                <div class="col-md-4">
                    <select name="class_id" class="form-select">
                        <option value="">-- All Classes --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ (string)$classId === (string)$c->id ? 'selected' : '' }}>
                                {{ $c->class_name }} {{ $c->section ? '(' . $c->section . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Student</th>
                            <th>Status</th>
                            <th style="width:140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr>
                                <td>{{ $row->date }}</td>
                                <td>{{ $row->class->class_name ?? '-' }}</td>
                                <td>
                                    {{ $row->student->roll_number ?? '' }} - {{ $row->student->name ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge {{ $row->status === 'present' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.attendance.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.attendance.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this attendance record?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No attendance found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
