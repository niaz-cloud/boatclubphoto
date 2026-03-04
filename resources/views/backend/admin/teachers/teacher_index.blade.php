@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">Teachers</h5>
                <small class="text-muted">Manage all teachers</small>
            </div>

            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i>
                Add Teacher
            </a>
        </div>


        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $teacher->name }}</td>

                                <td>{{ $teacher->email }}</td>

                                <td>

                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                        class="btn btn-sm btn-warning">

                                        Edit

                                    </a>

                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this teacher?')">

                                            Delete

                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No teachers found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>
@endsection
