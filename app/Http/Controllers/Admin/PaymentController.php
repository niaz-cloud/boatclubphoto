<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Package;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * ✅ Payment List (Admin Panel)
     */
    public function index()
    {
        $data['active_menu'] = 'payments';
        $data['page_title']  = 'Payments';

        $payments = Payment::with(['student', 'package'])
            ->latest()
            ->paginate(10);

        return view(
            'backend.admin.payments.Payments_index',
            compact('payments', 'data')
        );
    }

    /**
     * ➕ Show Add Payment Form
     */
    public function create()
    {
        $data['active_menu'] = 'payments';
        $data['page_title']  = 'Add Payment';

        $students = Student::orderBy('name')->get();
        $packages = Package::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'backend.admin.payments.Payments_create',
            compact('students', 'packages', 'data')
        );
    }

    /**
     * 💾 Store Payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'   => 'required|exists:students,id',
            'package_id'   => 'required|exists:packages,id', // ✅ FIXED
            'amount'       => 'required|numeric|min:0',
            'payment_type' => 'required|string|max:255',
            'status'       => 'required|in:pending,paid',
            'payment_date' => 'required|date',
        ]);

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment added successfully.');
    }

    /**
     * ✅ Mark Payment Paid
     */
    public function markPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'paid'
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }
}
