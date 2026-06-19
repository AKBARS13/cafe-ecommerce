<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Payment\PaymentFactory;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();

        if ($cartItems->isEmpty()) {
            return $this->errorRedirect('Keranjang belanja kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $total = $this->cartService->calculateTotal();
        $tax = $total * 0.1;
        $grandTotal = $total + $tax;
        $paymentMethods = PaymentFactory::getAvailableMethods();

        return view('checkout.index', compact('cartItems', 'total', 'tax', 'grandTotal', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'order_type' => 'required|in:dine_in,takeaway',
            'table_number' => 'nullable|string|max:10',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $result = $this->orderService->createOrder($request->all());
            return redirect()->route('orders.show', $result['order']->id)
                ->with('success', 'Pesanan berhasil dibuat! ' . $result['payment']['message']);
        } catch (\Exception $e) {
            return $this->errorRedirect('Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}