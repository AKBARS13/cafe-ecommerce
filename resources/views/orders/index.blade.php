@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-receipt text-amber-500 mr-2"></i> Pesanan Saya
    </h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">

                        <div>
                            <div class="flex items-center space-x-3 mb-2 flex-wrap gap-2">
                                <h3 class="font-bold text-lg text-gray-800">{{ $order->order_number }}</h3>

                                {{-- Status Badge --}}
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

                                {{-- Payment Badge --}}
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $order->payment_status_label }}
                                </span>
                            </div>

                            <p class="text-gray-500 text-sm">
                                <i class="fas fa-calendar mr-1"></i> {{ $order->getFormattedDate() }}
                                <span class="mx-2">|</span>
                                <i class="fas fa-shopping-bag mr-1"></i> {{ $order->items->count() }} item
                                <span class="mx-2">|</span>
                                <i class="fas fa-{{ $order->order_type === 'dine_in' ? 'chair' : 'shopping-bag' }} mr-1"></i>
                                {{ $order->order_type === 'dine_in' ? 'Dine In' : 'Takeaway' }}
                            </p>
                        </div>

                        <div class="mt-4 md:mt-0 flex items-center space-x-4">
                            <span class="text-amber-600 font-bold text-lg">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition text-sm font-semibold">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-receipt text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Belum ada pesanan</p>
            <a href="{{ route('products.index') }}"
                class="bg-amber-600 text-white px-8 py-3 rounded-full hover:bg-amber-500 transition font-semibold">
                <i class="fas fa-utensils mr-2"></i> Mulai Pesan
            </a>
        </div>
    @endif
</div>
@endsection