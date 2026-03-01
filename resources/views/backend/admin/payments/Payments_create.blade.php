@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">Add Payment</h5>
                <small class="text-muted">Create a new student payment</small>
            </div>

            <a href="{{ route('admin.payments.index') }}" class="btn btn-light shadow-sm">
                ← Back to List
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Student --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Student</label>
                            <select name="student_id" class="form-control @error('student_id') is-invalid @enderror"
                                required>
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} (Roll: {{ $student->roll_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Package --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package</label>
                            <select name="package_id" id="packageSelect"
                                class="form-control @error('package_id') is-invalid @enderror" required>
                                <option value="">Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}" data-price="{{ $package->price }}"
                                        {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }} (৳{{ $package->price }})
                                    </option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (৳)</label>
                            <input type="number" step="0.01" name="amount" id="amountInput"
                                class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount"
                                value="{{ old('amount') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Payment Type --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Type</label>
                            <select name="payment_type" class="form-control @error('payment_type') is-invalid @enderror"
                                required>
                                <option value="">Select Type</option>
                                <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bkash" {{ old('payment_type') == 'bkash' ? 'selected' : '' }}>bKash
                                </option>
                                <option value="nagad" {{ old('payment_type') == 'nagad' ? 'selected' : '' }}>Nagad
                                </option>
                                <option value="card" {{ old('payment_type') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank" {{ old('payment_type') == 'bank' ? 'selected' : '' }}>Bank Transfer
                                </option>
                            </select>
                            @error('payment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Payment Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date"
                                class="form-control @error('payment_date') is-invalid @enderror"
                                value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fa-solid fa-save me-1"></i>
                            Save Payment
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Auto Fill Amount Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const packageSelect = document.getElementById('packageSelect');
            const amountInput = document.getElementById('amountInput');

            if (packageSelect) {
                packageSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    amountInput.value = price ? price : '';
                });
            }
        });
    </script>

@endsection
