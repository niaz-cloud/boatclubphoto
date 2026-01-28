@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between mb-3">
        <h5>Classes</h5>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm">
            + Add Class
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Class</th>
                <th>Section</th>
                <th>Code</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $class->class_name }}</td>
                <td>{{ $class->section ?? '-' }}</td>
                <td>{{ $class->class_code }}</td>
                <td>
                    <span class="badge {{ $class->status ? 'bg-success' : 'bg-secondary' }}">
                        {{ $class->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.classes.edit', $class->id) }}"
                       class="btn btn-success btn-sm">Edit</a>

                    <form method="POST"
                          action="{{ route('admin.classes.destroy', $class->id) }}"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this class?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No classes found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $classes->links() }}
</div>
@endsection
