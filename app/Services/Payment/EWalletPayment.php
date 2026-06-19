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

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        $qrCode = 'CAFE-' . $order->order_number . '-' . time();

        return [
            'success' => true,
            'message' => 'Pembayaran e-wallet berhasil.',
            'data' => [
                'method' => 'E-Wallet',
                'total' => $total,
                'admin_fee' => $this->adminFee,
                'wallet_type' => $paymentData['wallet_type'] ?? 'QRIS',
                'qr_code' => $qrCode,
            ]
        ];
    }

    public function validatePayment(array $paymentData): bool
    {
        return true;
    }

    public function getPaymentMethodName(): string
    {
        return 'E-Wallet (QRIS)';
    }

    public function getPaymentInstructions(): string
    {
        return 'Scan QR code QRIS menggunakan aplikasi e-wallet Anda (GoPay, OVO, DANA, ShopeePay, dll).';
    }
}