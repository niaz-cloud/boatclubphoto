@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="mb-0 fw-bold">Edit Admin</h5>
            <small class="text-muted">Update administrator information</small>
        </div>

        <a href="{{ route('admin.admins.index') }}"
           class="btn btn-outline-secondary btn-sm">
            ← Back
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Admin Update Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.admins.update', $admin->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $admin->name) }}"
                               required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $admin->email) }}"
                               required>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ strtoupper($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-success px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Update Admin
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- Reset Password Card --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">

            <h6 class="fw-bold mb-3">Reset Password</h6>

            <form method="POST"
                  action="{{ route('admin.admins.reset_password', $admin->id) }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-danger px-4">
                        <i class="fa-solid fa-key me-1"></i>
                        Reset Password
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
