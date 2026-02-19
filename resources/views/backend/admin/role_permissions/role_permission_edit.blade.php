@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="mb-0 fw-bold">Manage Role Permissions</h5>
            <small class="text-muted">
                Role: <strong>{{ strtoupper($role->name) }}</strong>
            </small>
        </div>

        <a href="{{ route('admin.role_permissions.index') }}"
           class="btn btn-outline-secondary btn-sm">
            ← Back
        </a>
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

    {{-- Permission Form --}}
    <form method="POST"
          action="{{ route('admin.role_permissions.update', $role->id) }}">
        @csrf

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- Global Select All --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Permissions</h6>

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               id="selectAll">

                        <label class="form-check-label fw-semibold"
                               for="selectAll">
                            Select All
                        </label>
                    </div>
                </div>

                <hr>

                {{-- Grouped Permissions --}}
                @foreach($groupedPermissions as $group => $permissions)

                    <div class="mb-4">

                        {{-- Group Header --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-capitalize mb-2">
                                {{ str_replace('_', ' ', $group) }}
                            </h6>

                            {{-- Group Select All --}}
                            <div class="form-check">
                                <input class="form-check-input group-select"
                                       type="checkbox"
                                       data-group="group-{{ $loop->index }}"
                                       id="groupSelect{{ $loop->index }}">

                                <label class="form-check-label"
                                       for="groupSelect{{ $loop->index }}">
                                    Select All
                                </label>
                            </div>
                        </div>

                        {{-- Permission Checkboxes --}}
                        <div class="row g-2 group-{{ $loop->index }}">

                            @foreach($permissions as $permission)

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">

                                        <input class="form-check-input perm-checkbox"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="perm{{ md5($permission->name) }}"
                                               {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>

                                        <label class="form-check-label"
                                               for="perm{{ md5($permission->name) }}">
                                            {{ ucwords($permission->name) }}
                                        </label>

                                    </div>
                                </div>

                            @endforeach

                        </div>

                        <hr>

                    </div>

                @endforeach

                {{-- Save Button --}}
                <div class="text-end">
                    <button type="submit"
                            class="btn btn-success px-4 shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Save Permissions
                    </button>
                </div>

            </div>
        </div>

    </form>

</div>

{{-- ✅ Select All Script --}}
<script>
    // Global Select All
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = this.checked);
        document.querySelectorAll('.group-select').forEach(cb => cb.checked = this.checked);
    });

    // Group Select All
    document.querySelectorAll('.group-select').forEach(groupToggle => {
        groupToggle.addEventListener('change', function () {
            let groupClass = this.dataset.group;
            document.querySelectorAll(`.${groupClass} .perm-checkbox`)
                .forEach(cb => cb.checked = this.checked);
        });
    });
</script>

@endsection
