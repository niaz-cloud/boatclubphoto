@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create New Admin</h4>
            <p class="text-muted mb-0">
                Add a new administrator with limited system access
            </p>
        </div>

        <a href="{{ route('admin.admins.index') }}"
           class="btn btn-outline-secondary btn-sm">
            ← Back to Admin List
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body px-4 py-4">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- Admin Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Admin Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               placeholder="Enter full name"
                               value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Email Address <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               placeholder="admin@example.com"
                               value="{{ old('email') }}">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               placeholder="Minimum 6 characters">

                        <small class="text-muted">Use a strong password</small>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role</label>

                        <input type="text"
                               class="form-control form-control-lg bg-light"
                               value="Admin"
                               readonly>

                        <small class="text-muted">
                            This user will have admin-level access (not super admin)
                        </small>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-5">

                    <a href="{{ route('admin.admins.index') }}"
                       class="btn btn-light px-4">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-success px-4 shadow-sm">
                        <i class="fa-solid fa-user-plus me-1"></i>
                        Create Admin
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
