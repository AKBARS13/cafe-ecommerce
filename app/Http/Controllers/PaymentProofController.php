<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class PaymentProofController extends BaseController
{
    private function getCloudinary()
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dohbxopsh',
                'api_key' => '619143837518466',
                'api_secret' => 'mL7LUpRY7_OljTEUbj-0pJiqxQw',
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function upload(Request $request, int $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $order = Order::findOrFail($orderId);

        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan order pakai transfer atau e_wallet
        if (!in_array($order->payment_method, ['transfer', 'e_wallet'])) {
            return back()->with('error', 'Order ini tidak memerlukan upload bukti pembayaran.');
        }

        // Upload ke Cloudinary
        $cloudinary = $this->getCloudinary();
        $result = $cloudinary->uploadApi()->upload(
            $request->file('payment_proof')->getRealPath(),
            ['folder' => 'payment_proofs']
        );

        $order->update([
            'payment_proof' => $result['secure_url'],
            'payment_status' => 'pending_verification',
            'payment_rejection_reason' => null, // reset alasan reject kalau ada
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}