<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminPaymentController extends BaseController
{
    public function index()
    {
        $pendingPayments = Order::where('payment_status', 'pending_verification')
            ->with(['user', 'bankAccount'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('pendingPayments'));
    }

    public function verify(Request $request, int $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment_status !== 'pending_verification') {
            return back()->with('error', 'Pembayaran ini tidak dalam status menunggu verifikasi.');
        }

        $order->update([
            'payment_status' => 'paid',
            'payment_verified_at' => now(),
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function reject(Request $request, int $orderId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->payment_status !== 'pending_verification') {
            return back()->with('error', 'Pembayaran ini tidak dalam status menunggu verifikasi.');
        }

        $order->update([
            'payment_status' => 'rejected',
            'payment_rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Pembayaran ditolak. Customer perlu upload bukti baru.');
    }
}