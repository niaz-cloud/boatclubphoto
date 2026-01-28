@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
    <h5 class="mb-3">Edit Exam</h5>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Exam Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $exam->name) }}">
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Question</label>
                        <input type="number" name="total_question" class="form-control" value="{{ old('total_question', $exam->total_question) }}">
                        @error('total_question')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Per Question Mark</label>
                        <input type="number" step="0.01" name="per_question_mark" class="form-control" value="{{ old('per_question_mark', $exam->per_question_mark) }}">
                        @error('per_question_mark')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Negative Mark</label>
                        <input type="number" step="0.01" name="negative_mark" class="form-control" value="{{ old('negative_mark', $exam->negative_mark) }}">
                        @error('negative_mark')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Question Set</label>
                        <input type="number" name="total_question_set" class="form-control" value="{{ old('total_question_set', $exam->total_question_set) }}">
                        @error('total_question_set')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pass Mark</label>
                        <input type="number" step="0.01" name="pass_mark" class="form-control" value="{{ old('pass_mark', $exam->pass_mark) }}">
                        @error('pass_mark')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Mark (Auto)</label>
                        <input type="text" class="form-control" value="{{ $exam->total_mark }}" disabled>
                    </div>

                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
