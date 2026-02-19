@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="mb-0 fw-bold">Admin Details</h5>
            <small class="text-muted">View administrator information</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.admins.index') }}"
               class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>

            <a href="{{ route('admin.admins.edit', $admin->id) }}"
               class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square me-1"></i>
                Edit
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row">

                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-semibold">Name</label>
                    <div class="fs-6">{{ $admin->name }}</div>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-semibold">Email</label>
                    <div class="fs-6">{{ $admin->email }}</div>
                </div>

                {{-- Roles --}}
                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-semibold">Role</label>
                    <div>
                        @forelse($admin->roles as $role)
                            <span class="badge bg-primary">
                                {{ strtoupper($role->name) }}
                            </span>
                        @empty
                            <span class="text-muted">No role assigned</span>
                        @endforelse
                    </div>
                </div>

                {{-- Created --}}
                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-semibold">Created At</label>
                    <div class="fs-6">
                        {{ $admin->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
