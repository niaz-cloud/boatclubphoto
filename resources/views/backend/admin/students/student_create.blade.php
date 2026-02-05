@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h5 class="mb-0 fw-semibold">Add Student</h5>

        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Roll Number <span class="text-danger">*</span></label>
                        <input type="text" name="roll_number"
                               class="form-control"
                               value="{{ old('roll_number') }}"
                               required>
                        @error('roll_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- ✅ NEW: Class Dropdown --}}
                    <div class="col-md-6">
                        <label class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} {{ $class->section ? '(' . $class->section . ')' : '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('class_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Save Student
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
