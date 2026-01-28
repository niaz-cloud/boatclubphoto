@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
        <h5 class="mb-0 fw-semibold">Auditor List</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.auditors.create') }}" class="btn btn-success btn-sm px-3">
                + Add Auditor
            </a>

            <a href="#" class="btn btn-warning btn-sm px-3">
                <i class="fa-solid fa-download"></i> Excel
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="auditorsTable" class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">SL</th>
                            <th style="width:90px;">PHOTO</th>
                            <th>NAME</th>
                            <th style="width:160px;">PHONE</th>
                            <th style="width:240px;">EMAIL</th>
                            <th style="width:120px;">STATUS</th>
                            <th style="width:120px;">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($auditors as $key => $auditor)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                {{-- PHOTO (Avatar Logic) --}}
                                <td class="text-center">
                                    @php
                                        $photoPath = $auditor->photo
                                            ? asset('uploads/auditors/'.$auditor->photo)
                                            : asset('backend_assets/images/default-avatar.jpg');
                                    @endphp

                                    <img
                                        src="{{ $photoPath }}"
                                        onerror="this.onerror=null;this.src='{{ asset('backend_assets/images/default-avatar.jpg') }}';"
                                        class="rounded-circle border"
                                        style="width:45px;height:45px;object-fit:cover;"
                                        alt="Auditor"
                                    >
                                </td>

                                {{-- NAME --}}
                                <td>
                                    <div class="fw-semibold">{{ $auditor->name }}</div>
                                    <small class="text-muted">
                                        A.ID: {{ $auditor->auditor_code ?? 'N/A' }}
                                    </small>
                                </td>

                                {{-- PHONE --}}
                                <td>{{ $auditor->phone ?? '-' }}</td>

                                {{-- EMAIL --}}
                                <td>{{ $auditor->email ?? '-' }}</td>

                                {{-- STATUS --}}
                                <td>
                                    @if((int)$auditor->status === 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                {{-- ACTION --}}
                                <td class="text-center">
                                    <a href="{{ route('admin.auditors.edit', $auditor->id) }}"
                                       class="btn btn-success btn-sm"
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
                                                class="btn btn-danger btn-sm"
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

{{-- ================= STYLES ================= --}}
@push('css')
<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        padding: .25rem .5rem;
        font-size: .875rem;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: .875rem;
    }

    table.dataTable thead th {
        white-space: nowrap;
    }
</style>
@endpush

{{-- ================= SCRIPTS ================= --}}
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
                ]
            });
        }
    });
</script>
@endpush
