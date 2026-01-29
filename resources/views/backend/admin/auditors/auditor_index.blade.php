@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top Right Buttons --}}
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3 mt-4">
        <a href="{{ route('admin.auditors.create') }}" class="btn btn-success btn-sm px-3">
            + Add Auditor
        </a>
        <a href="#" class="btn btn-warning btn-sm px-3">
            <i class="fa-solid fa-download"></i> Excel
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

            <h4 class="text-center fw-bold mb-3">Auditor List</h4>

            <div class="table-responsive">
                <table id="auditorsTable" class="table restaurant-dt align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th style="width:90px;">PHOTO</th>
                            <th>NAME</th>
                            <th style="width:150px;">PHONE</th>
                            <th style="width:260px;">EMAIL</th>
                            <th style="width:120px;">STATUS</th>
                            <th style="width:110px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($auditors as $key => $auditor)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                {{-- Photo --}}
                                <td>
                                    @php
                                        $photo = $auditor->photo
                                            ? asset('uploads/auditors/'.$auditor->photo)
                                            : asset('backend_assets/images/default-avatar.jpg');
                                    @endphp
                                    <img src="{{ $photo }}"
                                         class="restaurant-avatar"
                                         alt="Auditor"
                                         onerror="this.onerror=null;this.src='{{ asset('backend_assets/images/default-avatar.jpg') }}';">
                                </td>

                                {{-- Name --}}
                                <td>
                                    <div class="fw-semibold">{{ $auditor->name }}</div>
                                    <small class="text-muted">A.ID: {{ $auditor->auditor_code ?? 'N/A' }}</small>
                                </td>

                                <td>{{ $auditor->phone ?? '-' }}</td>
                                <td>{{ $auditor->email ?? '-' }}</td>

                                {{-- Status --}}
                                <td>
                                    @if((int)$auditor->status === 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td>
                                    <a href="{{ route('admin.auditors.edit', $auditor->id) }}"
                                       class="restaurant-action restaurant-edit"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.auditors.destroy', $auditor->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this auditor?')">
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    No auditors found
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

    /* ✅ Show entries dropdown (fixed ugly size) */
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

    /* Avatar */
    .restaurant-avatar{
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        background: #f3f4f6 !important;
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
            $('#auditorsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [1, 6] }
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
