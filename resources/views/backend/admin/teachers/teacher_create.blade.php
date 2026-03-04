@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h5 class="fw-bold mb-0">Add Teacher</h5>

            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary btn-sm">
                ← Back to List
            </a>
        </div>


        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('admin.teachers.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Teacher Name</label>

                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>

                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Password --}}
                        <div class="col-md-6">
                            <label class="form-label">Password</label>

                            <input type="password" name="password" class="form-control" required>

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            Save Teacher
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
