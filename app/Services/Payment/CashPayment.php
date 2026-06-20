<?php

namespace App\Services\Payment;

use App\Abstracts\AbstractPaymentProcessor;
use App\Models\Order;

class CashPayment extends AbstractPaymentProcessor
{
    public function __construct()
    {
        $this->paymentMethod = 'cash';
        $this->adminFee = 0;
    }

    public function processPayment(Order $order, array $paymentData): array
    {
        // Cash langsung dianggap selesai (atau bisa unpaid sampai datang)
        $order->update([
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
        ]);

        return [
            'success' => true,
            'message' => 'Pesanan tunai berhasil dibuat. Silakan bayar di kasir.',
            'data' => [
                'method' => 'Tunai',
                'total' => $order->total_amount,
            ]
        ];
    }

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        return [
            'success' => true,
            'message' => 'Pembayaran tunai berhasil',
        ];
    }

    public function validatePayment(array $paymentData): bool
    {
        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'Pembayaran Tunai';
    }

    public function getPaymentInstructions(): string
    {
        return 'Silakan bayar langsung di kasir dengan uang tunai saat datang.';
    }
}