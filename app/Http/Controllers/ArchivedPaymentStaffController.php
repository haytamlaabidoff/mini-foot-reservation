<?php

namespace App\Http\Controllers;

use App\Models\ArchivedPaymentStaff;

class ArchivedPaymentStaffController extends Controller
{
    // 📋 list archive
    public function index()
    {
        $archives = ArchivedPaymentStaff::with('staff.user')
            ->latest()
            ->get();
            

        return view('archived_payments.index', compact('archives'));
    }

    // 👁 show single (optional)
    public function show($id)
    {
        $archive = ArchivedPaymentStaff::with('staff.user')->findOrFail($id);

        return view('archived_payments.show', compact('archive'));
    }
}