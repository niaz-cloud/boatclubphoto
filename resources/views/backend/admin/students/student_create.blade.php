@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">Add Student</h5>
                <small class="text-muted">Create a new student and assign class & teacher</small>
            </div>

            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary shadow-sm">
                Back
            </a>
        </div>


        {{-- Student Form --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Student Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter student name"
                                required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Roll Number --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Roll Number</label>
                            <input type="text" name="roll_number" class="form-control" placeholder="Enter roll number"
                                required>

                            @error('roll_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Password --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password"
                                required>

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">

                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Class --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Class</label>

                            <select name="class_id" class="form-select" required>

                                <option value="">Select Class</option>

                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('class_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Teacher Assignment --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assign Teacher</label>

                            <select name="teacher_id" class="form-select">

                                <option value="">Select Teacher</option>

                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('teacher_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                    </div>


                    {{-- Submit --}}
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            Create Student
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
