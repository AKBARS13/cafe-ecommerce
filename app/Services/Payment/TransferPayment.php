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

    protected function executePayment(Order $order, float $total, array $paymentData): array
    {
        return [
            'success' => true,
            'message' => 'Pembayaran transfer berhasil dicatat. Menunggu verifikasi.',
            'data' => [
                'method' => 'Transfer Bank',
                'total' => $total,
                'admin_fee' => $this->adminFee,
                'bank' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'Cafe Kopi Nusantara',
            ]
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
        return 'Transfer ke rekening BCA 1234567890 a.n. Cafe Kopi Nusantara. Kirim bukti transfer ke kasir.';
    }
}