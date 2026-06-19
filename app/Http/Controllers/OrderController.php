<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getOrdersByUser(Auth::id());
        return view('orders.index', compact('orders'));
    }

    public function show(int $orderId)
    {
        $order = $this->orderService->getOrderDetail($orderId);

        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
}