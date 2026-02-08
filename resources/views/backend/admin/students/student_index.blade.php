@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top Right Button --}}
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3 mt-4">
        <a href="{{ route('admin.students.create') }}" class="btn btn-success btn-sm px-3">
            + Add Student
        </a>
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
                                        <a href="{{ route('admin.students.edit', $student->id) }}"
                                           class="action-btn edit"
                                           title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        {{-- Delete --}}
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

{{-- ================= STYLES ================= --}}
@push('css')
<style>
/* Datatable spacing */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter{
    margin-bottom: 10px !important;
}

.dataTables_wrapper .dataTables_filter input{
    width: 220px !important;
    height: 34px !important;
    padding: 0 10px !important;
    font-size: 14px !important;
    border: 1px solid #d1d5db !important;
    border-radius: 4px !important;
}

.dataTables_wrapper .dataTables_length select{
    height: 34px !important;
    padding: 0 10px !important;
    font-size: 14px !important;
}

/* Table */
table.restaurant-dt thead th{
    font-size: 12px !important;
    font-weight: 600 !important;
    color: #5b6ea6 !important;
    text-transform: uppercase !important;
}

table.restaurant-dt tbody td{
    padding: 12px 10px !important;
    font-size: 14px !important;
    vertical-align: middle !important;
}

/* Action buttons */
.action-group{
    display: flex;
    justify-content: center;
    gap: 8px;
}

.action-btn{
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.action-btn i{
    font-size: 13px;
    color: #fff;
}

/* Colors */
.action-btn.view{ background:#2563eb; }
.action-btn.edit{ background:#16a34a; }
.action-btn.delete{ background:#ef4444; }

/* Hover */
.action-btn:hover{
    transform: translateY(-1px);
    opacity: 0.9;
}

table.dataTable.no-footer{
    border-bottom: 0 !important;
}
</style>
@endpush

{{-- ================= SCRIPTS ================= --}}
@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (window.$ && $.fn.DataTable) {

        const table = $('#studentsTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 4] }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search"
            }
        });

        // Auto SL numbering
        table.on('order.dt search.dt draw.dt', function () {
            let i = 1;
            table.cells(null, 0, { search: 'applied', order: 'applied' })
                .every(function () {
                    this.data(i++);
                });
        }).draw();
    }
});
</script>
@endpush
