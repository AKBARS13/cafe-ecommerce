@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-credit-card text-amber-500 mr-2"></i> Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Checkout Form --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Info --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-user mr-2 text-amber-500"></i> Informasi Pelanggan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                            <input type="text" name="customer_name"
                                value="{{ Auth::user()->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                            <input type="text" name="customer_phone"
                                value="{{ Auth::user()->phone }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>
                </div>

                {{-- Order Type --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-store mr-2 text-amber-500"></i> Tipe Pesanan
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="dine_in" checked class="sr-only peer">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                <i class="fas fa-chair text-2xl text-amber-600 mb-2"></i>
                                <p class="font-semibold">Makan di Tempat</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="takeaway" class="sr-only peer">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                <i class="fas fa-shopping-bag text-2xl text-amber-600 mb-2"></i>
                                <p class="font-semibold">Takeaway</p>
                            </div>
                        </label>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nomor Meja (jika dine-in)
                        </label>
                        <input type="text" name="table_number" placeholder="Contoh: A5"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-wallet mr-2 text-amber-500"></i> Metode Pembayaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($paymentMethods as $key => $name)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="{{ $key }}"
                                    {{ $loop->first ? 'checked' : '' }} class="sr-only peer">
                                <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                    @if($key === 'cash')
                                        <i class="fas fa-money-bill-wave text-2xl text-green-600 mb-2"></i>
                                    @elseif($key === 'transfer')
                                        <i class="fas fa-university text-2xl text-blue-600 mb-2"></i>
                                    @else
                                        <i class="fas fa-qrcode text-2xl text-purple-600 mb-2"></i>
                                    @endif
                                    <p class="font-semibold text-sm">{{ $name }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-sticky-note mr-2 text-amber-500"></i> Catatan Tambahan
                    </h2>
                    <textarea name="notes" rows="3"
                        placeholder="Catatan khusus untuk pesanan Anda..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                </div>

            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    {{ $item->product->name }} x{{ $item->quantity }}
                                </span>
                                <span class="font-semibold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-4">

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">PPN (10%)</span>
                            <span class="font-semibold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold text-gray-800">Total Bayar</span>
                            <span class="font-bold text-amber-600">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-6 bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold text-lg">
                        <i class="fas fa-check-circle mr-2"></i> Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}"
                        class="block mt-3 text-center text-amber-600 hover:text-amber-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection