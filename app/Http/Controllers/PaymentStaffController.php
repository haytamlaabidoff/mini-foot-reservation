<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentStaff;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ArchivedPaymentStaff; // 🔥 زيدها فوق مع use

class PaymentStaffController extends Controller
{
    // 📋 list payments
    public function index()
    {
        $payments = PaymentStaff::with('staff.user')
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

    // ➕ create form (staff selected)
    public function create($staff)
    {
        $staff = Staff::with('user')->findOrFail($staff);

        return view('payments.create', compact('staff'));
    }

    // 💾 store payment
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'status' => 'required|in:paid,unpaid,pending',
            'amount' => 'nullable|numeric',
            'note' => 'nullable|string',
        ]);

        $staff = Staff::findOrFail($request->staff_id);

        $paidAt = now();

        // 🔥 salary auto from staff
        $amount = $request->amount ?? $staff->salary;

        // 🔥 next payment = +1 month
        $nextPayment = $paidAt->copy()->addMonth();

      PaymentStaff::create([
    'staff_id' => $staff->id,
    'amount' => $amount,
    'month' => now()->format('Y-m'),
    'status' => $request->status,
    'paid_by' => Auth::id(),
    'paid_at' => $paidAt,
    'next_payment_at' => $nextPayment,
    'note' => $request->note,
]);

        return redirect()->route('payments.index')
            ->with('success', 'Paiement ajouté avec succès');
    }




public function pay($id)
{
    $payment = PaymentStaff::findOrFail($id);

    $paidAt = now();

    // ✅ update current payment
    $payment->update([
        'status' => 'paid',
        'paid_at' => $paidAt,
        'next_payment_at' => $paidAt->copy()->addMonth(),
    ]);

    // ✅ archive
    ArchivedPaymentStaff::create([
        'staff_id' => $payment->staff_id,
        'amount' => $payment->amount,
        'month' => $payment->month,
        'paid_at' => $payment->paid_at,
        'next_payment_at' => $payment->next_payment_at,
        'paid_by' => auth()->id(),
    ]);

    // 🔥 CREATE NEXT MONTH PAYMENT
    PaymentStaff::create([
        'staff_id' => $payment->staff_id,
        'amount' => $payment->amount,
        'month' => Carbon::parse($payment->month . '-01')->addMonth()->format('Y-m'),
        'status' => 'unpaid',
        'paid_by' => null,
        'paid_at' => null,
        'next_payment_at' => $paidAt->copy()->addMonth(),
    ]);

    // 🧹 delete old
    $payment->delete();

    return back()->with('success', 'Paiement payé + prochain mois créé');
}
}