@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Menu Kami <i class="fas fa-utensils text-amber-500"></i></h1>
        <p class="text-gray-500 mt-2">Temukan kopi dan makanan favoritmu</p>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari menu..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua Tipe</option>
                    <option value="food" {{ request('type') == 'food' ? 'selected' : '' }}>Makanan</option>
                    <option value="drink" {{ request('type') == 'drink' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ request('type') == 'snack' ? 'selected' : '' }}>Snack</option>
                    <option value="dessert" {{ request('type') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                </select>
            </div>
            <div>
                <select name="sort" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-amber-600 text-white py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">Tidak ada produk yang ditemukan.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-500 transition">
                Reset Filter
            </a>
        </div>
    @endif

</div>
@endsection