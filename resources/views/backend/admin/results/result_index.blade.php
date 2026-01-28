@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

<div class="alert alert-danger">ADD Result INDEX VIEW LOADED ✅</div>
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

    <div class="card">
        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th>Exam</th>
                            <th style="width:150px;">Roll</th>
                            <th style="width:90px;">Correct</th>
                            <th style="width:90px;">Wrong</th>
                            <th style="width:120px;">Obtained</th>
                            <th style="width:110px;">Total</th>
                            <th style="width:110px;">Pass</th>
                            <th style="width:110px;">Status</th>
                            <th style="width:120px;">Action</th>
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
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-3">
                                    No results found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $results->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
