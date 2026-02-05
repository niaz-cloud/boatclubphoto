@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
            <h5 class="mb-0 fw-semibold">Mark Attendance</h5>
            <small class="text-muted">Select class & date, then mark Present/Absent</small>
        </div>

        <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Step 1: select class & date --}}
            <form method="GET" action="{{ route('admin.attendance.create') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ (string)$classId === (string)$c->id ? 'selected' : '' }}>
                                {{ $c->class_name }} {{ $c->section ? '(' . $c->section . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Load</button>
                </div>
            </form>

            @if($classId)
                <form method="POST" action="{{ route('admin.attendance.store') }}">
                    @csrf

                    <input type="hidden" name="class_id" value="{{ $classId }}">
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted">
                            Total Students: <b>{{ $students->count() }}</b>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success" onclick="setAll('present')">Mark All Present</button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="setAll('absent')">Mark All Absent</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:90px;">Roll</th>
                                    <th>Student</th>
                                    <th style="width:220px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $s)
                                    @php
                                        $st = $existing[$s->id] ?? 'absent';
                                    @endphp
                                    <tr>
                                        <td>{{ $s->roll_number }}</td>
                                        <td>{{ $s->name }}</td>
                                        <td>
                                            <select name="status[{{ $s->id }}]" class="form-select form-select-sm status-select">
                                                <option value="present" {{ $st === 'present' ? 'selected' : '' }}>Present</option>
                                                <option value="absent"  {{ $st === 'absent' ? 'selected' : '' }}>Absent</option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No students found in this class</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-success mt-2 px-4">Save Attendance</button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function setAll(val){
    document.querySelectorAll('.status-select').forEach(el => el.value = val);
}
</script>
@endpush
