@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
   <div class="alert alert-danger">STUDENT INDEX VIEW LOADED ✅</div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
        <h5 class="mb-0 fw-semibold">Student List</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.create') }}" class="btn btn-success btn-sm px-3">
                + Add Student
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="studentsTable" class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th style="width:160px;">ROLL</th>
                            <th>NAME</th>
                            <th style="width:160px;">PHONE</th>
                            <th style="width:120px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $key => $student)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-semibold">{{ $student->roll_number }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>

                                <td class="text-center">
                                    <a href="{{ route('admin.students.edit', $student->id) }}"
                                       class="btn btn-success btn-sm"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.students.destroy', $student->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this student?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
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

@push('css')
<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input{
        padding: .25rem .5rem;
        font-size: .875rem;
    }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate{
        font-size: .875rem;
    }
    table.dataTable thead th{
        white-space: nowrap;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.$ && $.fn.DataTable) {
            $('#studentsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [4] } // action unsortable
                ]
            });
        }
    });
</script>
@endpush
