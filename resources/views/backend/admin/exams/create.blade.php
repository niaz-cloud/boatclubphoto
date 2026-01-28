@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
            <h5 class="mb-0 fw-semibold">Add Exam</h5>
            <small class="text-muted">Create a new exam with marking rules</small>
        </div>

        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.exams.store') }}" method="POST">
                @csrf

                {{-- Exam Basic Info --}}
                <div class="mb-3">
                    <h6 class="mb-2 fw-semibold">Exam Information</h6>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Midterm Math">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Total Question <span class="text-danger">*</span></label>
                            <input type="number" id="total_question" name="total_question" class="form-control"
                                   value="{{ old('total_question') }}" placeholder="e.g. 50" min="1">
                            @error('total_question')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Total Question Set <span class="text-danger">*</span></label>
                            <input type="number" name="total_question_set" class="form-control"
                                   value="{{ old('total_question_set', 1) }}" placeholder="e.g. 1" min="1">
                            @error('total_question_set')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                    </div>
                </div>

                <hr class="my-3">

                {{-- Marking Rules --}}
                <div class="mb-3">
                    <h6 class="mb-2 fw-semibold">Marking Rules</h6>
                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label">Per Question Mark <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="per_question_mark" name="per_question_mark"
                                   class="form-control" value="{{ old('per_question_mark', 1) }}" min="0">
                            @error('per_question_mark')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Negative Mark</label>
                            <input type="number" step="0.01" name="negative_mark"
                                   class="form-control" value="{{ old('negative_mark', 0) }}" min="0">
                            @error('negative_mark')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Pass Mark <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="pass_mark"
                                   class="form-control" value="{{ old('pass_mark') }}" min="0" placeholder="e.g. 40">
                            @error('pass_mark')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Total Mark</label>
                            <input type="text" id="total_mark" class="form-control" value="0.00" disabled>
                            <small class="text-muted">Auto calculated (Total Q × Per Q)</small>
                        </div>

                    </div>
                </div>

                <hr class="my-3">

                {{-- Actions --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-success px-4">Save</button>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-light px-4">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>

{{-- Auto calculate total mark --}}
<script>
    const totalQuestion = document.getElementById('total_question');
    const perQuestionMark = document.getElementById('per_question_mark');
    const totalMark = document.getElementById('total_mark');

    function calculateTotalMark() {
        const tq = parseFloat(totalQuestion.value) || 0;
        const pq = parseFloat(perQuestionMark.value) || 0;
        totalMark.value = (tq * pq).toFixed(2);
    }

    totalQuestion.addEventListener('input', calculateTotalMark);
    perQuestionMark.addEventListener('input', calculateTotalMark);
    calculateTotalMark();
</script>
@endsection
