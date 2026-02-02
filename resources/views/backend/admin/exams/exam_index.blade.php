@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
        <h5 class="mb-0 fw-semibold">Exam List</h5>

        <a href="{{ route('admin.exams.create') }}" class="btn btn-success btn-sm px-3">
            + Add Exam
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Center Title like Restaurant table --}}
            <h4 class="text-center fw-bold mb-4">Exam List</h4>

            <div class="table-responsive">
                <table id="examsTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>NAME</th>
                            <th style="width:90px;">TOTAL Q</th>
                            <th style="width:110px;">PER Q</th>
                            <th style="width:100px;">NEGATIVE</th>
                            <th style="width:90px;">SET</th>
                            <th style="width:110px;">TOTAL</th>
                            <th style="width:100px;">PASS</th>
                            <th style="width:120px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td>{{ $exam->id }}</td>
                                <td class="fw-medium">{{ $exam->name }}</td>
                                <td>{{ $exam->total_question }}</td>
                                <td>{{ number_format($exam->per_question_mark, 2) }}</td>
                                <td>{{ number_format($exam->negative_mark, 2) }}</td>
                                <td>{{ $exam->total_question_set }}</td>
                                <td>{{ number_format($exam->total_mark, 2) }}</td>
                                <td>{{ number_format($exam->pass_mark, 2) }}</td>

                                {{-- Action --}}
                                <td>
                                    <a href="{{ route('admin.exams.edit', $exam->id) }}"
                                       class="restaurant-action restaurant-edit"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this exam?')">
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
                                <td colspan="9" class="text-center text-muted py-4">
                                    No exams found.
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
    /* ===== Restaurant/Operator DataTable look (Exams page only) ===== */

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter{
        margin-bottom: 14px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label{
        font-size: 14px;
        font-weight: 500;
        color: #475569;
    }

     /* Show entries dropdown – clean & centered */
.dataTables_wrapper .dataTables_length select{
    min-width: 72px !important;        /* proper width */
    height: 34px !important;           /* match input height */
    padding: 0 10px !important;        /* vertical centering */
    font-size: 14px !important;
    line-height: 34px !important;      /* fix text alignment */
    border: 1px solid #d1d5db !important;
    border-radius: 4px !important;
    background-color: #ffffff !important;
    outline: none !important;
    box-shadow: none !important;
}


    /* Search input */
    .dataTables_wrapper .dataTables_filter input{
        width: 220px;
        height: 34px;
        padding: 0 10px;
        font-size: 14px;
        line-height: 34px;
        border: 1px solid #d1d5db !important;
        border-radius: 4px;
        background: #fff;
        outline: none;
        box-shadow: none;
    }

    /* Header */
    table.restaurant-dt thead th{
        font-size: 12px;
        font-weight: 600;
        color: #5b6ea6;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 12px 10px !important;
        white-space: nowrap;
        background: transparent !important;
    }

    /* Body */
    table.restaurant-dt tbody td{
        border-bottom: 1px solid #e5e7eb !important;
        padding: 14px 10px !important;
        font-size: 14px;
        vertical-align: middle;
    }

    table.dataTable.no-footer{
        border-bottom: 0 !important;
    }

    /* Action buttons match operator list */
    .restaurant-action{
        width: 32px;
        height: 28px;
        border-radius: 4px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        margin-right: 6px;
    }

    .restaurant-edit{ background: #16a34a !important; }
    .restaurant-delete{ background: #f43f5e !important; }

    .restaurant-action i{
        color: #fff !important;
        font-size: 13px;
    }
</style>
@endpush


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.$ && $.fn.DataTable) {
            $('#examsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [8] }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search"
                }
            });
        }
    });
</script>
@endpush
