@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $order->order_number }}</h1>
            <p class="text-gray-500">{{ $order->getFormattedDate() }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Informasi Pesanan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Pesanan</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->status_color === 'yellow') bg-yellow-100 text-yellow-800
                        @elseif($order->status_color === 'blue') bg-blue-100 text-blue-800
                        @elseif($order->status_color === 'indigo') bg-indigo-100 text-indigo-800
                        @elseif($order->status_color === 'green') bg-green-100 text-green-800
                        @elseif($order->status_color === 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $order->status_label }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Bayar</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $order->payment_status_label }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tipe Pesanan</span>
                    <span class="font-semibold">
                        {{ $order->order_type === 'dine_in' ? 'Makan di Tempat' : 'Takeaway' }}
                    </span>
                </div>
                @if($order->table_number)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nomor Meja</span>
                        <span class="font-semibold">{{ $order->table_number }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Bayar</span>
                    <span class="font-semibold capitalize">
                        {{ str_replace('_', ' ', $order->payment_method) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Informasi Pelanggan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama</span>
                    <span class="font-semibold">{{ $order->customer_name }}</span>
                </div>
                @if($order->customer_phone)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Telepon</span>
                        <span class="font-semibold">{{ $order->customer_phone }}</span>
                    </div>
                @endif
                @if($order->notes)
                    <div>
                        <span class="text-gray-600">Catatan:</span>
                        <p class="font-semibold mt-1">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4">Item Pesanan</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between py-3 border-b last:border-0">
                    <div class="flex items-center space-x-4">
                        @if($item->product && $item->product->image)
                            <img src="{{ $item->product->image }}"
                                alt="{{ $item->product_name }}"
                                class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-mug-hot text-amber-300"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">
                                Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}
                            </p>
                            @if($item->notes)
                                <p class="text-xs text-gray-400">
                                    <i class="fas fa-sticky-note mr-1"></i> {{ $item->notes }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <span class="font-bold text-gray-800">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4">Ringkasan Pembayaran</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">PPN</span>
                <span class="font-semibold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Diskon</span>
                    <span class="font-semibold">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
            @endif
            <hr>
            <div class="flex justify-between text-lg">
                <span class="font-bold text-gray-800">Total Bayar</span>
                <span class="font-bold text-amber-600">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

</div>
@endsection