@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h5 class="fw-bold mb-0">Payments</h5>
            <small class="text-muted">Manage student payments & transactions</small>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Payments Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Student</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Student --}}
                                <td class="fw-semibold">
                                    {{ $payment->student->name ?? 'N/A' }}
                                </td>

                                {{-- Package --}}
                                <td>
                                    {{ $payment->package->name ?? 'N/A' }}
                                </td>

                                {{-- Amount --}}
                                <td>
                                    <span class="fw-semibold">
                                        ৳ {{ number_format($payment->amount, 2) }}
                                    </span>
                                </td>

                                {{-- Method --}}
                                <td>
                                    <span class="text-muted">
                                        {{ strtoupper($payment->method ?? 'N/A') }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="badge bg-{{ 
                                        $payment->status === 'paid' ? 'success' : 
                                        ($payment->status === 'failed' ? 'danger' : 'warning') 
                                    }}">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td class="text-end">

                                    @if($payment->status !== 'paid')

                                        <form method="POST"
                                              action="{{ route('admin.payments.mark_paid', $payment->id) }}"
                                              class="d-inline">
                                            @csrf

                                            <button class="btn btn-sm btn-success shadow-sm">
                                                <i class="fa-solid fa-check me-1"></i>
                                                Mark Paid
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-success fw-semibold small">
                                            <i class="fa-solid fa-check-circle me-1"></i>
                                            Completed
                                        </span>
                                    @endif

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fa-regular fa-face-smile fs-4 d-block mb-2"></i>
                                        No payments found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $payments->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
