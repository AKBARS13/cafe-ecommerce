<?php

namespace App\Services\Payment;

use App\Contracts\PaymentInterface;
use InvalidArgumentException;

class PaymentFactory
{
    public static function create(string $method): PaymentInterface
    {
        return match ($method) {
            'cash' => new CashPayment(),
            'transfer' => new TransferPayment(),
            'e_wallet' => new EWalletPayment(),
            default => throw new InvalidArgumentException("Metode pembayaran '{$method}' tidak didukung."),
        };
    }

    public static function getAvailableMethods(): array
    {
        return [
            'cash' => (new CashPayment())->getPaymentMethodName(),
            'transfer' => (new TransferPayment())->getPaymentMethodName(),
            'e_wallet' => (new EWalletPayment())->getPaymentMethodName(),
        ];
    }
}