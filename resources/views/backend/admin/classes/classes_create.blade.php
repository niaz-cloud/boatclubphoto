@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
    <h5>Add Class</h5>

    <form method="POST" action="{{ route('admin.classes.store') }}">
        @csrf

        <div class="mb-2">
            <label>Class Name</label>
            <input name="class_name" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Section</label>
            <input name="section" class="form-control">
        </div>

        <div class="mb-2">
            <label>Class Code</label>
            <input name="class_code" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Academic Year</label>
            <input name="academic_year" class="form-control">
        </div>

        <div class="mb-2">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
