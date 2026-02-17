@extends('backend.admin.includes.admin_layout')

@section('content')

<style>
    .edit-card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: none;
    }

    .form-control {
        border-radius: 8px;
    }
</style>

<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h5 class="mb-0 fw-semibold">Edit Student</h5>

        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back to List
        </a>
    </div>

    <div class="card edit-card">
        <div class="card-body">

            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Roll --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Roll Number <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="roll_number"
                               class="form-control"
                               value="{{ old('roll_number', $student->roll_number) }}"
                               required>
                        @error('roll_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Student Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name', $student->name) }}"
                               required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email', $student->user->email ?? '') }}"
                               required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password"
                               class="form-control">
                        <small class="text-muted">Leave blank to keep current</small>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Update Student
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
