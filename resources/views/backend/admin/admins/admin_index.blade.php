@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="mb-0 fw-bold">Admin List</h5>
            <small class="text-muted">Manage system administrators</small>
        </div>

        @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.admins.create') }}" 
               class="btn btn-success btn-sm px-3 shadow-sm">
                <i class="fa-solid fa-user-plus me-1"></i>
                Add Admin
            </a>
        @endif
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Admin Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 120px;">Role</th>
                            <th class="text-end" style="width: 170px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $admin->name }}
                                </td>

                                <td class="text-muted">
                                    {{ $admin->email }}
                                </td>

                                <td>
                                    @if($admin->role === 'super_admin')
                                        <span class="badge bg-danger">Super Admin</span>
                                    @else
                                        <span class="badge bg-primary text-capitalize">
                                            {{ $admin->role }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end">

                                    @if(auth()->id() !== $admin->id)

                                        {{-- VIEW --}}
                                        <a href="{{ route('admin.admins.show', $admin->id) }}"
                                           class="btn btn-sm btn-light border me-1 action-btn view-btn"
                                           title="View">
                                            <i class="fa-solid fa-eye text-info"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        @if(auth()->user()->role === 'super_admin')
                                            <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                               class="btn btn-sm btn-light border me-1 action-btn edit-btn"
                                               title="Edit">
                                                <i class="fa-solid fa-pen text-warning"></i>
                                            </a>
                                        @endif

                                        {{-- DELETE --}}
                                        @if(auth()->user()->role === 'super_admin' && $admin->role !== 'super_admin')
                                            <form action="{{ route('admin.admins.destroy', $admin->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-light border action-btn delete-btn"
                                                        title="Delete"
                                                        onclick="return confirm('Delete this admin?')">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        @endif

                                    @else
                                        <span class="badge bg-secondary">You</span>
                                    @endif

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fa-regular fa-face-smile fs-4 d-block mb-2"></i>
                                        No admins found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

{{-- Button Styling --}}
<style>
.action-btn {
    width: 34px;
    height: 34px;
    padding: 0;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.action-btn i {
    font-size: 13px;
}

.view-btn:hover {
    background-color: rgba(13, 202, 240, 0.08);
}

.edit-btn:hover {
    background-color: rgba(255, 193, 7, 0.12);
}

.delete-btn:hover {
    background-color: rgba(220, 53, 69, 0.12);
}
</style>

@endsection
