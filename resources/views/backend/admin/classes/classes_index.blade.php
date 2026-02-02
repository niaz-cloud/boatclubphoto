@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top Right Buttons --}}
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3 mt-4">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-success btn-sm px-3">
            + Add Class
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-3">Class List</h4>

            <div class="table-responsive">
                <table id="classesTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th>CLASS</th>
                            <th>SECTION</th>
                            <th style="width:140px;">CODE</th>
                            <th style="width:120px;">STATUS</th>
                            <th style="width:110px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                {{-- ✅ SL auto-filled by DataTable --}}
                                <td></td>

                                <td class="fw-semibold">{{ $class->class_name }}</td>
                                <td>{{ $class->section ?? '-' }}</td>
                                <td>{{ $class->class_code }}</td>

                                <td>
                                    @if($class->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.classes.edit', $class->id) }}"
                                       class="restaurant-action restaurant-edit"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.classes.destroy', $class->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this class?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="restaurant-action restaurant-delete"
                                                title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
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

@push('css')
<style>
    /* Keep controls tight like Restaurant */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter{
        margin-bottom: 10px !important;
    }

    /* Search box */
    .dataTables_wrapper .dataTables_filter input{
        width: 220px !important;
        height: 34px !important;
        padding: 0 10px !important;
        font-size: 14px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 4px !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* Show entries dropdown */
    .dataTables_wrapper .dataTables_length select{
        min-width: 72px !important;
        height: 34px !important;
        padding: 0 10px !important;
        font-size: 14px !important;
        line-height: 34px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 4px !important;
        background: #fff !important;
        outline: none !important;
        box-shadow: none !important;
        appearance: auto !important;
    }

    /* Table header */
    table.restaurant-dt thead th{
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #5b6ea6 !important;
        text-transform: uppercase !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 10px 10px !important;
        white-space: nowrap !important;
        background: transparent !important;
    }

    /* Table body */
    table.restaurant-dt tbody td{
        border-bottom: 1px solid #e5e7eb !important;
        padding: 12px 10px !important;
        font-size: 14px !important;
        vertical-align: middle !important;
    }

    /* Action buttons */
    .restaurant-action{
        width: 32px !important;
        height: 28px !important;
        border-radius: 4px !important;
        border: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        cursor: pointer !important;
        margin-right: 6px !important;
    }
    .restaurant-edit{ background: #16a34a !important; }
    .restaurant-delete{ background: #f43f5e !important; }
    .restaurant-action i{ color: #fff !important; font-size: 13px !important; }

    /* Remove bottom border */
    table.dataTable.no-footer{ border-bottom: 0 !important; }
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (window.$ && $.fn.DataTable) {

        $('#classesTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[1, 'asc']], // CLASS
            columnDefs: [
                { orderable: false, targets: [0, 4, 5] } // SL + STATUS + ACTION
            ],
            language: {
                search: "",
                searchPlaceholder: "Search"
            },

            // ✅ This will always fill SL column
            drawCallback: function () {
                const api = this.api();
                api.column(0, { search: 'applied', order: 'applied' })
                   .nodes()
                   .each(function (cell, i) {
                       cell.innerHTML = i + 1;
                   });
            }
        });
    }
});
</script>
@endpush
