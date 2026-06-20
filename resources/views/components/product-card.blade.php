<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
    <a href="{{ route('products.show', $product->slug) }}">
        @if($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-amber-100 flex items-center justify-center">
                <i class="fas fa-mug-hot text-amber-300 text-5xl"></i>
            </div>
        @endif
    </a>

    <div class="p-4">
        @if($product->has_discount)
            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        @if($product->is_featured)
            <span class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full ml-1">
                <i class="fas fa-star"></i> Unggulan
            </span>
        @endif

        <a href="{{ route('products.show', $product->slug) }}">
            <h3 class="font-bold text-gray-800 mt-2 hover:text-amber-600 transition">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-gray-500 text-sm mt-1">{{ $product->category->name }}</p>

        <div class="mt-3">
            @if($product->has_discount)
                <span class="text-gray-400 line-through text-sm">{{ $product->getFormattedPrice() }}</span>
                <span class="text-amber-600 font-bold text-lg ml-1">{{ $product->formatted_final_price }}</span>
            @else
                <span class="text-amber-600 font-bold text-lg">{{ $product->getFormattedPrice() }}</span>
            @endif
        </div>

        @auth
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="w-full bg-amber-600 text-white py-2 rounded-lg hover:bg-amber-500 transition text-sm font-semibold {{ !$product->isActive() ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ !$product->isActive() ? 'disabled' : '' }}>
                    @if($product->isActive())
                        <i class="fas fa-cart-plus mr-1"></i> Tambah ke Keranjang
                    @else
                        <i class="fas fa-times mr-1"></i> Stok Habis
                    @endif
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block mt-3 text-center bg-amber-600 text-white py-2 rounded-lg hover:bg-amber-500 transition text-sm font-semibold">
                <i class="fas fa-sign-in-alt mr-1"></i> Login untuk Pesan
            </a>
        @endauth
    </div>
</div>