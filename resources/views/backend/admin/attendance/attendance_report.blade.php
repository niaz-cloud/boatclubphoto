@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    <h5 class="fw-bold mb-3">Attendance Report</h5>

    {{-- Filter form --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <label class="form-label">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ $from }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ $to }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select">
                <option value="">-- All Classes --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ (string)$classId === (string)$c->id ? 'selected' : '' }}>
                        {{ $c->class_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end gap-2">
            <button class="btn btn-primary">Generate</button>

            @if($rows->count())
                {{-- CSV Export (Excel compatible) --}}
                <a href="{{ route('admin.attendance.report.csv', request()->query()) }}"
                   class="btn btn-success">
                    CSV
                </a>

                {{-- PDF Export --}}
                <a href="{{ route('admin.attendance.report.pdf', request()->query()) }}"
                   class="btn btn-danger">
                    PDF
                </a>
            @endif
        </div>
    </form>

    {{-- Report table --}}
    @if($rows->count())
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Class</th>
                        <th>Student</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                            </td>
                            <td>{{ $row->class->class_name ?? '-' }}</td>
                            <td>
                                {{ $row->student->roll_number ?? '' }} -
                                {{ $row->student->name ?? '-' }}
                            </td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted text-center mt-4">No data found</p>
    @endif

</div>
@endsection
