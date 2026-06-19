@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-amber-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-mug-hot text-amber-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-receipt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pelanggan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_customers'] }}</p>
            </div>
            <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Today Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-white">
        <p class="text-amber-100 text-sm">Pesanan Pending</p>
        <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
    </div>
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <p class="text-blue-100 text-sm">Pesanan Hari Ini</p>
        <p class="text-3xl font-bold">{{ $stats['today_orders'] }}</p>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <p class="text-green-100 text-sm">Revenue Hari Ini</p>
        <p class="text-2xl font-bold">
            Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-amber-600 hover:text-amber-700 text-sm font-semibold">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-3 font-semibold text-gray-600">No. Order</th>
                    <th class="pb-3 font-semibold text-gray-600">Pelanggan</th>
                    <th class="pb-3 font-semibold text-gray-600">Total</th>
                    <th class="pb-3 font-semibold text-gray-600">Status</th>
                    <th class="pb-3 font-semibold text-gray-600">Bayar</th>
                    <th class="pb-3 font-semibold text-gray-600">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="text-amber-600 hover:text-amber-700 font-semibold">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td class="py-3">{{ $order->user->name ?? '-' }}</td>
                        <td class="py-3 font-semibold">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($order->status_color === 'yellow') bg-yellow-100 text-yellow-800
                                @elseif($order->status_color === 'blue') bg-blue-100 text-blue-800
                                @elseif($order->status_color === 'indigo') bg-indigo-100 text-indigo-800
                                @elseif($order->status_color === 'green') bg-green-100 text-green-800
                                @elseif($order->status_color === 'red') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $order->payment_status_label }}
                            </span>
                        </td>
                        <td class="py-3 text-gray-500">{{ $order->getFormattedDate() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection