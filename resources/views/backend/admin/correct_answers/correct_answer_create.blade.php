@extends('backend.admin.includes.admin_layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-2 mt-4">
    <h5 class="mb-0 fw-semibold">Add Correct Answer</h5>

    <a href="{{ route('admin.correct_answers.index') }}" class="btn btn-secondary btn-sm px-3">
        Back
    </a>
</div>

<div class="page-content">

    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-3">
            <form method="POST" action="{{ route('admin.correct_answers.store') }}">
                @csrf

                <div class="mb-2">
                    <label class="form-label mb-1">Exam</label>
                    <select name="exam_id" class="form-select form-select-sm" required>
                        <option value="">Select Exam</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label mb-1">Set Number</label>
                        <input type="text" name="set_number" value="{{ old('set_number') }}"
                               class="form-control form-control-sm" placeholder="A / B / 1" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mb-1">Question Number</label>
                        <input type="number" name="question_number" value="{{ old('question_number') }}"
                               class="form-control form-control-sm" min="1" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mb-1">Correct Option</label>
                        <input type="text" name="student_option" value="{{ old('student_option') }}"
                               class="form-control form-control-sm" placeholder="A / B / C / D" required>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-success btn-sm px-4">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
