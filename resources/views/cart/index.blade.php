@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-shopping-cart text-amber-500 mr-2"></i> Keranjang Belanja
    </h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-xl shadow-md p-4 flex items-center space-x-4">

                        @if($item->product->image)
                            <img src="{{ $item->product->image }}"
                                alt="{{ $item->product->name }}"
                                class="w-20 h-20 rounded-lg object-cover">
                        @else
                            <div class="w-20 h-20 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-mug-hot text-amber-300 text-2xl"></i>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800">{{ $item->product->name }}</h3>
                            <p class="text-amber-600 font-semibold">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                            @if($item->notes)
                                <p class="text-gray-400 text-sm">
                                    <i class="fas fa-sticky-note mr-1"></i> {{ $item->notes }}
                                </p>
                            @endif
                        </div>

                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="submit" name="quantity" value="{{ max(0, $item->quantity - 1) }}"
                                    class="px-2 py-1 hover:bg-gray-100 rounded-l-lg">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="px-3 py-1 bg-gray-50 text-sm font-semibold">
                                    {{ $item->quantity }}
                                </span>
                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                    class="px-2 py-1 hover:bg-gray-100 rounded-r-lg">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                        </form>

                        <div class="text-right">
                            <p class="font-bold text-gray-800">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:text-red-700">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach

                <div class="text-right">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-500 hover:text-red-700 text-sm"
                            onclick="return confirm('Kosongkan seluruh keranjang?')">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 text-sm">
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
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-amber-600">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                        class="block mt-6 text-center bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold">
                        <i class="fas fa-credit-card mr-2"></i> Checkout
                    </a>

                    <a href="{{ route('products.index') }}"
                        class="block mt-3 text-center text-amber-600 hover:text-amber-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Keranjang belanja Anda kosong</p>
            <a href="{{ route('products.index') }}"
                class="bg-amber-600 text-white px-8 py-3 rounded-full hover:bg-amber-500 transition font-semibold">
                <i class="fas fa-utensils mr-2"></i> Lihat Menu
            </a>
        </div>
    @endif

</div>
@endsection