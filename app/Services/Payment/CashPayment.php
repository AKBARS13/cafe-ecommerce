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

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        $cashReceived = $paymentData['cash_received'] ?? $total;
        $change = $cashReceived - $total;

        return [
            'success' => true,
            'message' => 'Pembayaran tunai berhasil',
            'data' => [
                'method' => 'Tunai',
                'total' => $total,
                'cash_received' => $cashReceived,
                'change' => max(0, $change),
            ]
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
        return 'Silakan bayar langsung di kasir dengan uang tunai.';
    }
}