<?php

namespace App\Abstracts;

use App\Contracts\PaymentInterface;
use App\Models\Order;

abstract class AbstractPaymentProcessor implements PaymentInterface
{
    protected string $paymentMethod;
    protected float $adminFee = 0;

    public function processPayment(Order $order, array $paymentData): array
    {
        if (!$this->validatePayment($paymentData)) {
            return [
                'success' => false,
                'message' => 'Data pembayaran tidak valid'
            ];
        }

        $totalWithFee = $order->total_amount + $this->adminFee;

        $result = $this->executePayment($order, $totalWithFee, $paymentData);

        if ($result['success']) {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => $this->paymentMethod,
                'paid_at' => now(),
            ]);
        }

        return $result;
    }

    abstract protected function executePayment(Order $order, float $total, array $paymentData): array;

    public function getAdminFee(): float
    {
        return $this->adminFee;
    }
}