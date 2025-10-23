<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'method' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('payment_proof')?->store('payments');

        Payment::create([
            'reservation_id' => $request->reservation_id,
            'method' => $request->method,
            'amount' => $request->amount,
            'status' => 'pending',
            'payment_proof' => $path,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
