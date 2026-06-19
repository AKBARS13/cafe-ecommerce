<?php

namespace App\Services;

use App\Contracts\OrderInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Payment\PaymentFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderInterface
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $cartItems = $this->cartService->getItems();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang belanja kosong.');
            }

            $subtotal = $this->cartService->calculateTotal();
            $tax = $subtotal * 0.1;
            $discount = 0;
            $totalAmount = $subtotal + $tax - $discount;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cash',
                'payment_status' => 'unpaid',
                'order_type' => $data['order_type'] ?? 'dine_in',
                'table_number' => $data['table_number'] ?? null,
                'notes' => $data['notes'] ?? null,
                'customer_name' => $data['customer_name'] ?? $user->name,
                'customer_phone' => $data['customer_phone'] ?? $user->phone,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->subtotal,
                    'notes' => $cartItem->notes,
                ]);

                $cartItem->product->decreaseStock($cartItem->quantity);
            }

            $paymentProcessor = PaymentFactory::create($data['payment_method'] ?? 'cash');
            $paymentResult = $paymentProcessor->processPayment($order, $data);

            $this->cartService->clearCart();

            return [
                'order' => $order->load('items'),
                'payment' => $paymentResult,
            ];
        });
    }

    public function updateOrderStatus(int $orderId, string $status): mixed
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        return $order;
    }

    public function getOrdersByUser(int $userId): mixed
    {
        return Order::where('user_id', $userId)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderDetail(int $orderId): mixed
    {
        return Order::with(['items.product', 'user'])->findOrFail($orderId);
    }
}