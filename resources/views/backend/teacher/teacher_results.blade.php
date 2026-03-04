@extends('backend.teacher.teacher_layout')

@section('content')
    <h4 class="mb-4">Add Result</h4>

    <form action="{{ route('teacher.results.store') }}" method="POST">
        @csrf

        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <div class="mb-3">
            <label>Exam</label>
            <select name="exam_id" class="form-control">
                @foreach ($exams as $exam)
                    <option value="{{ $exam->id }}">
                        {{ $exam->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Marks</label>
            <input type="number" name="marks" class="form-control">
        </div>

        <div class="mb-3">
            <label>Grade</label>
            <input type="text" name="grade" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Save Result
        </button>

    </form>
@endsection
