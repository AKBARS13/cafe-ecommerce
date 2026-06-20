<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Models\Table;
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

        if ($request->has('order_type') && $request->order_type) {
            $query->where('order_type', $request->order_type);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $orderId)
    {
        $order = $this->orderService->getOrderDetail($orderId);
        $availableTables = Table::available()->orderBy('table_number')->get();
        return view('admin.orders.show', compact('order', 'availableTables'));
    }

    public function updateStatus(Request $request, int $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,ready,completed,cancelled',
        ]);

        $this->orderService->updateOrderStatus($orderId, $request->status);

        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function assignTable(Request $request, int $orderId)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
        ]);

        $order = Order::findOrFail($orderId);
        $table = Table::findOrFail($request->table_id);

        $order->update([
            'table_id' => $table->id,
            'table_number' => $table->table_number,
        ]);

        // Update status meja jadi occupied (untuk dine_in) atau reserved (untuk reservation)
        if ($order->order_type === 'dine_in') {
            $table->update(['status' => 'occupied']);
        } elseif ($order->order_type === 'reservation') {
            $table->update(['status' => 'reserved']);
        }

        return back()->with('success', 'Meja ' . $table->table_number . ' berhasil di-assign ke pesanan!');
    }

    public function releaseTable(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->table) {
            $order->table->update(['status' => 'available']);
        }

        $order->update([
            'table_id' => null,
            'table_number' => null,
        ]);

        return back()->with('success', 'Meja berhasil dikosongkan!');
    }
}