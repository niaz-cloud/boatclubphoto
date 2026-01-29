@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
        <h5 class="mb-0 fw-semibold">Results</h5>

        <a href="{{ route('admin.results.create') }}" class="btn btn-success btn-sm px-3">
            + Add Result
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2 mb-2">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-4">Result List</h4>

            <div class="table-responsive">
                <table id="resultsTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th>EXAM</th>
                            <th style="width:150px;">ROLL</th>
                            <th style="width:90px;">CORRECT</th>
                            <th style="width:90px;">WRONG</th>
                            <th style="width:120px;">OBTAINED</th>
                            <th style="width:110px;">TOTAL</th>
                            <th style="width:110px;">PASS</th>
                            <th style="width:110px;">STATUS</th>
                            <th style="width:120px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($results as $r)
                            @php
                                $dupesForExam = $duplicateMap[$r->exam_id] ?? [];
                                $isDup = in_array($r->roll_number, $dupesForExam);
                            @endphp

                            <tr>
                                <td>{{ $r->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $r->exam->name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:12px;">Exam ID: {{ $r->exam_id }}</div>
                                </td>

                                <td class="fw-semibold">
                                    {{ $r->roll_number }}
                                    @if($isDup)
                                        <span class="badge bg-danger ms-1">Duplicate</span>
                                    @endif
                                </td>

                                <td>{{ $r->correct_answer ?? 0 }}</td>
                                <td>{{ $r->wrong_answer ?? 0 }}</td>

                                <td class="fw-semibold">{{ number_format($r->obtained_mark ?? 0, 2) }}</td>
                                <td>{{ number_format($r->total_mark ?? 0, 2) }}</td>
                                <td>{{ number_format($r->pass_mark ?? 0, 2) }}</td>

                                <td>
                                    @if(($r->status ?? '') === 'pass')
                                        <span class="badge bg-success">Pass</span>
                                    @elseif(($r->status ?? '') === 'fail')
                                        <span class="badge bg-danger">Fail</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('admin.results.destroy', $r->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this result?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="restaurant-action restaurant-delete" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    No results found.
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
    /* ===== Restaurant/Operator DataTable look (Results page only) ===== */

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

   /* Fix "Show entries" dropdown */
.dataTables_wrapper .dataTables_length select{
    min-width: 80px !important;      /* proper width */
    height: 34px !important;
    padding: 0 28px 0 10px !important; /* space for arrow */
    font-size: 14px !important;
    line-height: 34px !important;    /* vertical centering */
    border: 1px solid #d1d5db !important;
    border-radius: 4px !important;
    background-color: #ffffff !important;
    outline: none !important;
    box-shadow: none !important;
}


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

    table.restaurant-dt tbody td{
        border-bottom: 1px solid #e5e7eb !important;
        padding: 14px 10px !important;
        font-size: 14px;
        vertical-align: middle;
    }

    table.dataTable.no-footer{
        border-bottom: 0 !important;
    }

    /* Action button style (delete) */
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
    .restaurant-delete{ background: #f43f5e !important; }
    .restaurant-action i{ color: #fff !important; font-size: 13px; }
</style>
@endpush


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.$ && $.fn.DataTable) {
            $('#resultsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [9] } // Action
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
