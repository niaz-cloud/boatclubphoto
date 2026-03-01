@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <div>
                <h4 class="fw-bold mb-0">Class Management</h4>
                <small class="text-muted">Manage all academic classes</small>
            </div>

            <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="fa-solid fa-plus me-1"></i> Add Class
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table id="classesTable" class="table table-hover align-middle w-100">

                        <thead class="table-light">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th style="width:140px;">Code</th>
                                <th style="width:120px;">Status</th>
                                <th style="width:110px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($classes as $class)
                                <tr>
                                    <td></td>

                                    <td class="fw-semibold">{{ $class->class_name }}</td>
                                    <td>{{ $class->section ?? '-' }}</td>
                                    <td>
                                        <span class="text-muted">{{ $class->class_code }}</span>
                                    </td>

                                    <td>
                                        @if ($class->status)
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            <a href="{{ route('admin.classes.edit', $class->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this class?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No classes found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
