@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
    <h5>Edit Class</h5>

    <form method="POST" action="{{ route('admin.classes.update', $class->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label>Class Name</label>
            <input name="class_name" class="form-control"
                   value="{{ $class->class_name }}" required>
        </div>

        <div class="mb-2">
            <label>Section</label>
            <input name="section" class="form-control"
                   value="{{ $class->section }}">
        </div>

        <div class="mb-2">
            <label>Class Code</label>
            <input name="class_code" class="form-control"
                   value="{{ $class->class_code }}" required>
        </div>

        <div class="mb-2">
            <label>Academic Year</label>
            <input name="academic_year" class="form-control"
                   value="{{ $class->academic_year }}">
        </div>

        <div class="mb-2">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $class->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
