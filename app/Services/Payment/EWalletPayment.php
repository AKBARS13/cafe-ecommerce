<?php

namespace App\Services\Payment;

use App\Abstracts\AbstractPaymentProcessor;
use App\Models\Order;

class EWalletPayment extends AbstractPaymentProcessor
{
    public function __construct()
    {
        $this->paymentMethod = 'e_wallet';
        $this->adminFee = 0;
    }

    public function processPayment(Order $order, array $paymentData): array
    {
        $order->update([
            'payment_method' => 'e_wallet',
            'payment_status' => 'unpaid',
        ]);

        return [
            'success' => true,
            'message' => 'Pesanan QRIS berhasil dibuat. Silakan scan QR dan upload bukti pembayaran.',
            'data' => [
                'method' => 'QRIS',
                'total' => $order->total_amount,
            ]
        ];
    }

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        return [
            'success' => true,
            'message' => 'Pembayaran QRIS dicatat',
        ];
    }

    public function validatePayment(array $paymentData): bool
    {
        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'QRIS / E-Wallet';
    }

    public function getPaymentInstructions(): string
    {
        return 'Scan QR Code QRIS, lakukan pembayaran, lalu upload bukti pembayaran.';
    }
}