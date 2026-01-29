@extends('backend.admin.includes.admin_layout')

@section('content')

{{-- ================= OMR ERROR LIST ================= --}}
<div class="d-flex justify-content-between align-items-center mb-2 mt-4">
    <h5 class="mb-0 fw-semibold">OMR Errors</h5>
</div>

<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2 mb-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= FILTER SECTION ================= --}}
    <div class="card mb-2">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('admin.omr_errors.index') }}" class="row g-2">

                <div class="col-md-4">
                    <label class="form-label mb-1">Exam</label>
                    <select name="exam_id" class="form-select form-select-sm">
                        <option value="">All Exams</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}"
                                {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label mb-1">Roll Number</label>
                    <input type="text"
                           name="roll_number"
                           value="{{ request('roll_number') }}"
                           class="form-control form-control-sm"
                           placeholder="Enter roll">
                </div>

                <div class="col-md-2">
                    <label class="form-label mb-1">Set</label>
                    <input type="text"
                           name="set_number"
                           value="{{ request('set_number') }}"
                           class="form-control form-control-sm"
                           placeholder="A / B">
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        Search
                    </button>
                    <a href="{{ route('admin.omr_errors.index') }}"
                       class="btn btn-secondary btn-sm px-3">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= TABLE SECTION ================= --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-4">OMR Error List</h4>

            <div class="table-responsive">
                <table id="omrErrorsTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>EXAM</th>
                            <th style="width:120px;">ROLL</th>
                            <th style="width:80px;">SET</th>
                            <th>FILE PATH</th>
                            <th>ERROR MESSAGE</th>
                            <th style="width:90px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($errors as $error)
                            <tr>
                                <td>{{ $error->id }}</td>
                                <td>{{ $error->exam->name ?? 'N/A' }}</td>
                                <td>{{ $error->roll_number ?? '-' }}</td>
                                <td>{{ $error->set_number ?? '-' }}</td>
                                <td class="text-muted">{{ $error->file_path }}</td>
                                <td class="text-danger">{{ $error->message }}</td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.omr_errors.destroy', $error->id) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this error?')">
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    No OMR errors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ❌ remove laravel pagination links because DataTables will paginate --}}
            {{-- <div class="mt-2">{{ $errors->links() }}</div> --}}

        </div>
    </div>
</div>

@endsection


@push('css')
<style>
    /* Same Restaurant/Operator DataTable look */
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

    .dataTables_wrapper .dataTables_length select{
        min-width: 80px !important;
        height: 34px !important;
        padding: 0 28px 0 10px !important;
        font-size: 14px !important;
        line-height: 34px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 4px !important;
        background-color: #fff !important;
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

    .restaurant-action{
        width: 32px;
        height: 28px;
        border-radius: 4px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .restaurant-delete{ background: #f43f5e !important; }
    .restaurant-action i{ color: #fff !important; font-size: 13px; }
</style>
@endpush


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.$ && $.fn.DataTable) {
            $('#omrErrorsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [6] } // Action
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
