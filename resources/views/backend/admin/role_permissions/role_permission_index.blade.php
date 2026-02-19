@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="mb-0 fw-bold">Role Permission Management</h5>
            <small class="text-muted">
                Select a role to manage permissions
            </small>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Role Selection Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <label class="form-label fw-semibold">
                Select Role
            </label>

            <select class="form-select form-select-lg"
                    onchange="if(this.value) window.location.href=this.value">

                <option value="">-- Choose Role --</option>

                @foreach($roles as $role)
                    <option value="{{ route('admin.role_permissions.edit', $role->id) }}">
                        {{ strtoupper($role->name) }}
                    </option>
                @endforeach

            </select>

            <small class="text-muted">
                Choose a role to configure its permissions
            </small>

        </div>
    </div>

</div>
@endsection
