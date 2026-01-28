@extends('backend.admin.includes.admin_layout')

@section('content')

{{-- ================= OMR ERROR LIST ================= --}}
<div class="d-flex justify-content-between align-items-center mb-2 mt-4">
    <h5 class="mb-0 fw-semibold">OMR Errors</h5>
</div>

<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2 mb-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= FILTER SECTION ================= --}}
    <div class="card mb-2">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('admin.omr_errors.index') }}" class="row g-2">

                <div class="col-md-4">
                    <label class="form-label mb-1">Exam</label>
                    <select name="exam_id" class="form-select form-select-sm">
                        <option value="">All Exams</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}"
                                {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label mb-1">Roll Number</label>
                    <input type="text"
                           name="roll_number"
                           value="{{ request('roll_number') }}"
                           class="form-control form-control-sm"
                           placeholder="Enter roll">
                </div>

                <div class="col-md-2">
                    <label class="form-label mb-1">Set</label>
                    <input type="text"
                           name="set_number"
                           value="{{ request('set_number') }}"
                           class="form-control form-control-sm"
                           placeholder="A / B">
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        Search
                    </button>
                    <a href="{{ route('admin.omr_errors.index') }}"
                       class="btn btn-secondary btn-sm px-3">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= TABLE SECTION ================= --}}
    <div class="card">
        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Exam</th>
                            <th style="width:120px;">Roll</th>
                            <th style="width:80px;">Set</th>
                            <th>File Path</th>
                            <th>Error Message</th>
                            <th style="width:90px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($errors as $error)
                            <tr>
                                <td>{{ $error->id }}</td>
                                <td>{{ $error->exam->name ?? 'N/A' }}</td>
                                <td>{{ $error->roll_number ?? '-' }}</td>
                                <td>{{ $error->set_number ?? '-' }}</td>
                                <td class="text-muted">
                                    {{ $error->file_path }}
                                </td>
                                <td class="text-danger">
                                    {{ $error->message }}
                                </td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.omr_errors.destroy', $error->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this error?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    No OMR errors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $errors->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
