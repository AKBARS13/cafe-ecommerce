@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-600">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-amber-600">Menu</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Image --}}
        <div>
            @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full rounded-xl shadow-lg object-cover max-h-96">
            @else
                <div class="w-full h-96 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-mug-hot text-amber-300 text-8xl"></i>
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-2">
                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $product->category->name }}
                </span>
                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-medium capitalize">
                    {{ $product->type }}
                </span>
                @if($product->is_featured)
                    <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-star"></i> Unggulan
                    </span>
                @endif
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

            <div class="mb-4">
                @if($product->has_discount)
                    <span class="text-gray-400 line-through text-lg">{{ $product->getFormattedPrice() }}</span>
                    <span class="text-amber-600 font-bold text-3xl ml-2">{{ $product->formatted_final_price }}</span>
                    <span class="bg-red-500 text-white text-sm px-2 py-1 rounded-full ml-2">
                        Hemat {{ $product->discount_percentage }}%
                    </span>
                @else
                    <span class="text-amber-600 font-bold text-3xl">{{ $product->getFormattedPrice() }}</span>
                @endif
            </div>

            <p class="text-gray-600 mb-6">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>

            <div class="flex items-center space-x-4 mb-6 text-sm text-gray-500">
                <span>
                    <i class="fas fa-box mr-1"></i> Stok:
                    <strong class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                    </strong>
                </span>
            </div>

            @auth
                @if($product->isActive())
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-4">
                            <label class="font-semibold text-gray-700">Jumlah:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="decreaseQty()" class="px-3 py-2 hover:bg-gray-100 rounded-l-lg">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none">
                                <button type="button" onclick="increaseQty()" class="px-3 py-2 hover:bg-gray-100 rounded-r-lg">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Catatan (opsional):</label>
                            <textarea name="notes" rows="2"
                                placeholder="Contoh: Kurang gula, es batu sedikit..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold text-lg">
                            <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl mb-2"></i>
                        <p class="text-red-600 font-semibold">Produk ini sedang tidak tersedia</p>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="block text-center bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold text-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Memesan
                </a>
            @endauth
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Menu Serupa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @include('components.product-card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif

</div>

<script>
    function decreaseQty() {
        let input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function increaseQty() {
        let input = document.getElementById('quantity');
        let max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
</script>
@endsection