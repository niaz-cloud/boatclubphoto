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

            {{-- Flash Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    Please fix the errors below.
                </div>
            @endif

            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Roll Number --}}
                    <div class="col-md-4">
                        <label class="form-label">Roll Number <span class="text-danger">*</span></label>
                        <input type="text"
                               name="roll_number"
                               class="form-control"
                               value="{{ old('roll_number') }}"
                               required>

                        @error('roll_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Student Name --}}
                    <div class="col-md-4">
                        <label class="form-label">Student Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               required>

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone') }}">

                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Email (Login) --}}
                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Password (Login) --}}
                    <div class="col-md-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control">
                    </div>

                    {{-- Class --}}
                    <div class="col-md-6">
                        <label class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                    {{ $class->section ? '(' . $class->section . ')' : '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('class_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- Submit --}}
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
