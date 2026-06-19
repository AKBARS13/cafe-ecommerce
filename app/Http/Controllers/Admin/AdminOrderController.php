<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminOrderController extends BaseController
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $orderId)
    {
        $order = $this->orderService->getOrderDetail($orderId);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,ready,completed,cancelled',
        ]);

        $this->orderService->updateOrderStatus($orderId, $request->status);

        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }
}