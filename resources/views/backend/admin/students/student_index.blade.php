@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top Right Button --}}
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3 mt-4">
        @can('create student')
            <a href="{{ route('admin.students.create') }}" class="btn btn-success btn-sm px-3">
                + Add Student
            </a>
        @endcan
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-3">Student List</h4>

            <div class="table-responsive">
                <table id="studentsTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th style="width:160px;">ROLL</th>
                            <th>NAME</th>
                            <th style="width:160px;">PHONE</th>
                            <th style="width:140px;" class="text-center">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                {{-- SL (auto-generated) --}}
                                <td></td>

                                <td class="fw-semibold">{{ $student->roll_number }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>

                                {{-- ACTION --}}
                                <td class="text-center">
                                    <div class="action-group">

                                        {{-- View --}}
                                        <a href="{{ route('admin.students.show', $student->id) }}"
                                           class="action-btn view"
                                           title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        @can('edit student')
                                            <a href="{{ route('admin.students.edit', $student->id) }}"
                                               class="action-btn edit"
                                               title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endcan

                                        {{-- Delete --}}
                                        @can('delete student')
                                            <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this student?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="action-btn delete"
                                                        title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No students found
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
