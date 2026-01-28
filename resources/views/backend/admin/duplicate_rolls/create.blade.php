@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
            <h5 class="mb-0 fw-semibold">Add Duplicate Roll</h5>
            <small class="text-muted">Select exam and enter the duplicate roll number</small>
        </div>

        <a href="{{ route('admin.duplicate-rolls.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    {{-- Flash Error --}}
    @if(session('error'))
        <div class="alert alert-danger py-2 mb-2">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.duplicate-rolls.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Exam Dropdown --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Exam <span class="text-danger">*</span>
                        </label>

                        <select name="exam_id" class="form-select">
                            <option value="">-- Select Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} (ID: {{ $exam->id }})
                                </option>
                            @endforeach
                        </select>

                        @error('exam_id')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Roll Number --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Roll Number <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="roll_number"
                               class="form-control"
                               value="{{ old('roll_number') }}"
                               placeholder="e.g. 20240012">

                        <small class="text-muted">
                            This roll will be saved as duplicate for the selected exam
                        </small>

                        @error('roll_number')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <hr class="my-3">

                {{-- Actions --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-success px-4">Save</button>
                    <a href="{{ route('admin.duplicate-rolls.index') }}" class="btn btn-light px-4">Cancel</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
