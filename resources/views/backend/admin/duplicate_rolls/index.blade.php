@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
        <h5 class="mb-0 fw-semibold">Duplicate Rolls</h5>

        <a href="{{ route('admin.duplicate-rolls.create') }}" class="btn btn-success btn-sm px-3">
            + Add Duplicate Roll
        </a>
    </div>

    {{-- Flash Messages --}}
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

    <div class="card">
        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Exam</th>
                            <th style="width:180px;">Roll Number</th>
                            <th style="width:150px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($duplicateRolls as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    {{ $item->exam->name ?? 'N/A' }}
                                    <div class="text-muted" style="font-size:12px;">
                                        Exam ID: {{ $item->exam_id }}
                                    </div>
                                </td>
                                <td class="fw-semibold">{{ $item->roll_number }}</td>
                                <td>
                                    <form action="{{ route('admin.duplicate-rolls.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this duplicate roll?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No duplicate rolls found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $duplicateRolls->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
