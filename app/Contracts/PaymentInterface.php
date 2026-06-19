<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentInterface
{
    public function processPayment(Order $order, array $paymentData): array;

    public function validatePayment(array $paymentData): bool;

    public function getPaymentMethodName(): string;

    public function getPaymentInstructions(): string;
}