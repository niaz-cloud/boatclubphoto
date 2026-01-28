@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-6">

        <h5 class="mb-0 fw-semibold">Exam List</h5>

        <a href="{{ route('admin.exams.create') }}"
           class="btn btn-success btn-sm px-3">
            + Add Exam
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Name</th>
                            <th style="width:90px;">Total Q</th>
                            <th style="width:110px;">Per Q</th>
                            <th style="width:100px;">Negative</th>
                            <th style="width:90px;">Set</th>
                            <th style="width:110px;">Total</th>
                            <th style="width:100px;">Pass</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    No exams found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $exams->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
