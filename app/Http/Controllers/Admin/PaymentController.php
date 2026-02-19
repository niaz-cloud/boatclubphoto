<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * ✅ Payment List (Admin Panel)
      */
    public function index()
    {
        $data['active_menu'] = 'payments';
        $data['page_title']  = 'Payments';

        // ✅ Load relationships
        $payments = Payment::with(['student', 'package'])
            ->latest()
            ->paginate(10);

        return view(
    'backend.admin.payments.Payments_index',
    compact('payments', 'data')
);
    }

    /**
     * ✅ Mark Payment Paid (Manual / Cash)
     */
    public function markPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'paid'
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }
}
