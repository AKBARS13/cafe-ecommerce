<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}