@extends('backend.student.student_layout')

@section('content')

<style>
    .profile-card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: none;
    }

    .profile-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-save {
        border-radius: 8px;
        padding: 8px 18px;
    }

    .divider {
        border-top: 1px solid #e5e7eb;
        margin: 25px 0;
    }
</style>

<div class="page-content">

    {{-- ===================== --}}
    {{-- Header --}}
    {{-- ===================== --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">👤 My Profile</h4>
        <p class="text-muted mb-0">
            Manage and update your personal information
        </p>
    </div>

    {{-- ===================== --}}
    {{-- Alerts --}}
    {{-- ===================== --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ===================== --}}
    {{-- Profile Update --}}
    {{-- ===================== --}}
    <div class="card profile-card">
        <div class="card-body">

            <h6 class="section-title">Profile Information</h6>

            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', auth()->user()->name) }}"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                           class="form-control"
                           value="{{ auth()->user()->email }}"
                           disabled>
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', auth()->user()->phone) }}">

                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-save">
                    Update Profile
                </button>

            </form>

            {{-- Divider --}}
            <div class="divider"></div>

            {{-- ===================== --}}
            {{-- Change Password --}}
            {{-- ===================== --}}
            <h6 class="section-title">Change Password</h6>

            <form method="POST" action="{{ route('student.password.update') }}">
                @csrf

                {{-- Current Password --}}
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password"
                           name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           required>

                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password"
                           name="new_password"
                           class="form-control @error('new_password') is-invalid @enderror"
                           required>

                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password"
                           name="new_password_confirmation"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-success btn-save">
                    Update Password
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
