<?php

namespace App\Services\Payment;

use App\Abstracts\AbstractPaymentProcessor;
use App\Models\Order;

class TransferPayment extends AbstractPaymentProcessor
{
    public function __construct()
    {
        $this->paymentMethod = 'transfer';
        $this->adminFee = 0;
    }

    public function processPayment(Order $order, array $paymentData): array
    {
        $order->update([
            'payment_method' => 'transfer',
            'payment_status' => 'unpaid',
            'bank_account_id' => $paymentData['bank_account_id'] ?? null,
        ]);

        return [
            'success' => true,
            'message' => 'Pesanan transfer berhasil dibuat. Silakan transfer dan upload bukti pembayaran.',
            'data' => [
                'method' => 'Transfer Bank',
                'total' => $order->total_amount,
            ]
        ];
    }

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        return [
            'success' => true,
            'message' => 'Pembayaran transfer dicatat',
        ];
    }

    public function validatePayment(array $paymentData): bool
    {
        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'Transfer Bank';
    }

    public function getPaymentInstructions(): string
    {
        return 'Transfer ke salah satu rekening yang tersedia, lalu upload bukti pembayaran.';
    }
}