@extends('backend.admin.includes.admin_layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-2 mt-4">
    <h5 class="mb-0 fw-semibold">Correct Answers</h5>

    <a href="{{ route('admin.correct_answers.create') }}" class="btn btn-success btn-sm px-3">
        + Add Answer
    </a>
</div>

<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="card mb-2">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('admin.correct_answers.index') }}" class="row g-2">
                <div class="col-md-5">
                    <label class="form-label mb-1">Exam</label>
                    <select name="exam_id" class="form-select form-select-sm">
                        <option value="">All Exams</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label mb-1">Set</label>
                    <input type="text" name="set_number" value="{{ request('set_number') }}"
                           class="form-control form-control-sm" placeholder="A / B / 1">
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary btn-sm px-3">Search</button>
                    <a href="{{ route('admin.correct_answers.index') }}" class="btn btn-secondary btn-sm px-3">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th>Exam</th>
                            <th style="width:90px;">Set</th>
                            <th style="width:120px;">Q No</th>
                            <th style="width:120px;">Answer</th>
                            <th style="width:90px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($answers as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->exam->name ?? 'N/A' }}</td>
                                <td>{{ $a->set_number }}</td>
                                <td>{{ $a->question_number }}</td>
                                <td class="fw-semibold">{{ $a->student_option }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.correct_answers.destroy', $a->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this answer?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    No answers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $answers->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
