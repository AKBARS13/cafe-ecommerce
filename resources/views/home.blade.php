@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-amber-900 via-amber-800 to-amber-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20 md:py-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">
                    Nikmati <span class="text-amber-300">Kopi</span> Terbaik Nusantara
                </h1>
                <p class="text-lg text-amber-200 mb-8">
                    Rasakan sensasi kopi pilihan dari berbagai daerah Indonesia. Ditemani makanan lezat, suasana nyaman, dan pelayanan terbaik.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('products.index') }}" class="bg-amber-500 hover:bg-amber-400 text-white px-8 py-3 rounded-full font-semibold transition transform hover:scale-105">
                        <i class="fas fa-utensils mr-2"></i> Lihat Menu
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="border-2 border-amber-300 text-amber-300 px-8 py-3 rounded-full font-semibold hover:bg-amber-300 hover:text-amber-900 transition">
                            <i class="fas fa-user-plus mr-2"></i> Daftar
                        </a>
                    @endguest
                </div>
            </div>
            <div class="hidden md:flex justify-center">
                <i class="fas fa-mug-hot text-amber-300 text-9xl opacity-50"></i>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6">
                <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-coffee text-amber-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800">Kopi Pilihan</h3>
                <p class="text-gray-500 text-sm mt-2">Biji kopi terbaik dari seluruh nusantara</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-amber-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800">Takeaway</h3>
                <p class="text-gray-500 text-sm mt-2">Pesan dan ambil langsung di cafe</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-amber-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800">Berbagai Pembayaran</h3>
                <p class="text-gray-500 text-sm mt-2">Tunai, Transfer, E-Wallet</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-amber-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800">Dibuat dengan Cinta</h3>
                <p class="text-gray-500 text-sm mt-2">Setiap sajian penuh perhatian</p>
            </div>
        </div>
    </div>
</section>

{{-- Categories --}}
@if($categories->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Kategori Menu</h2>
            <p class="text-gray-500 mt-2">Jelajahi berbagai pilihan menu kami</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition transform hover:-translate-y-1">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded-full mx-auto mb-4">
                    @else
                        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-utensils text-amber-600 text-2xl"></i>
                        </div>
                    @endif
                    <h3 class="font-bold text-gray-800">{{ $category->name }}</h3>
                    <p class="text-amber-600 text-sm mt-1">{{ $category->products_count }} produk</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
@if($featuredProducts->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Menu Unggulan <i class="fas fa-star text-amber-400"></i></h2>
            <p class="text-gray-500 mt-2">Pilihan favorit pelanggan kami</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Latest Products --}}
@if($latestProducts->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Menu Terbaru</h2>
            <p class="text-gray-500 mt-2">Coba menu terbaru kami</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="bg-amber-600 text-white px-8 py-3 rounded-full hover:bg-amber-500 transition font-semibold">
                Lihat Semua Menu <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

@endsection