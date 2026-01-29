@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top header (keep back button) --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
            <h5 class="mb-0 fw-semibold">Add Result</h5>
            <small class="text-muted">Select exam, enter roll and answers (system will calculate marks)</small>
        </div>

        <a href="{{ route('admin.results.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    {{-- Flash --}}
    @if(session('error'))
        <div class="alert alert-danger py-2 mb-2">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Center title like Restaurant --}}
            <h4 class="text-center fw-bold mb-4">Add Result</h4>

            <form action="{{ route('admin.results.store') }}" method="POST">
                @csrf

                {{-- 4 column layout like Restaurant --}}
                <div class="row g-3">

                    {{-- Exam --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Exam <span class="text-danger">*</span></label>
                        <select id="exam_id" name="exam_id" class="form-select form-control-like">
                            <option value="">-- Select Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}"
                                        data-per="{{ $exam->per_question_mark }}"
                                        data-neg="{{ $exam->negative_mark }}"
                                        data-pass="{{ $exam->pass_mark }}"
                                        {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} (ID: {{ $exam->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('exam_id')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Roll --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Roll Number <span class="text-danger">*</span></label>
                        <input type="text"
                               name="roll_number"
                               class="form-control form-control-like"
                               value="{{ old('roll_number') }}"
                               placeholder="e.g. 20240012">
                        @error('roll_number')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Correct --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Correct Answer <span class="text-danger">*</span></label>
                        <input type="number"
                               min="0"
                               id="correct_answer"
                               name="correct_answer"
                               class="form-control form-control-like"
                               value="{{ old('correct_answer', 0) }}">
                        @error('correct_answer')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Wrong --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Wrong Answer <span class="text-danger">*</span></label>
                        <input type="number"
                               min="0"
                               id="wrong_answer"
                               name="wrong_answer"
                               class="form-control form-control-like"
                               value="{{ old('wrong_answer', 0) }}">
                        @error('wrong_answer')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Obtained Preview --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Obtained Mark (Preview)</label>
                        <input type="text"
                               id="obtained_preview"
                               class="form-control form-control-like bg-light"
                               value="0.00"
                               disabled>
                        <small class="text-muted">Auto preview from exam rules</small>
                    </div>

                    {{-- Status Preview --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status (Preview)</label>
                        <input type="text"
                               id="status_preview"
                               class="form-control form-control-like bg-light"
                               value="Pending"
                               disabled>
                        <small class="text-muted">Pass/Fail preview</small>
                    </div>

                </div>

                {{-- Center buttons--}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5 btn-restaurant-save">Save</button>
                    <a href="{{ route('admin.results.index') }}" class="btn btn-light px-5 ms-2">Cancel</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('css')
<style>
    /* Match Restaurant form spacing/inputs */
    .form-control-like{
        height: 38px;
        border-radius: 4px;
    }
    .btn-restaurant-save{
        background: #6571ff;
        border-color: #6571ff;
    }
    .btn-restaurant-save:hover{
        background: #4f5bff;
        border-color: #4f5bff;
    }
</style>
@endpush

@push('js')
<script>
    const examSelect = document.getElementById('exam_id');
    const correctInput = document.getElementById('correct_answer');
    const wrongInput = document.getElementById('wrong_answer');
    const obtainedPreview = document.getElementById('obtained_preview');
    const statusPreview = document.getElementById('status_preview');

    function calcPreview() {
        const opt = examSelect.options[examSelect.selectedIndex];
        const per = parseFloat(opt?.dataset?.per || 0);
        const neg = parseFloat(opt?.dataset?.neg || 0);
        const pass = parseFloat(opt?.dataset?.pass || 0);

        const correct = parseFloat(correctInput.value || 0);
        const wrong = parseFloat(wrongInput.value || 0);

        let obtained = (correct * per) - (wrong * neg);
        if (obtained < 0) obtained = 0;

        obtainedPreview.value = obtained.toFixed(2);
        statusPreview.value = obtained >= pass ? 'Pass' : 'Fail';
    }

    if (examSelect) {
        examSelect.addEventListener('change', calcPreview);
        correctInput.addEventListener('input', calcPreview);
        wrongInput.addEventListener('input', calcPreview);
        calcPreview();
    }
</script>
@endpush
