@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}"
        class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori *</label>
                        <select name="category_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Diskon</label>
                        <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe *</label>
                        <select name="type" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="drink" {{ old('type', $product->type) == 'drink' ? 'selected' : '' }}>Minuman</option>
                            <option value="food" {{ old('type', $product->type) == 'food' ? 'selected' : '' }}>Makanan</option>
                            <option value="snack" {{ old('type', $product->type) == 'snack' ? 'selected' : '' }}>Snack</option>
                            <option value="dessert" {{ old('type', $product->type) == 'dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ $product->image }}"
                                    class="w-20 h-20 rounded-lg object-cover mb-2">
                                <label class="flex items-center text-sm">
                                    <input type="checkbox" name="remove_image" value="1"
                                        class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-red-600">Hapus gambar (kembalikan ke default)</span>
                                </label>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <p class="text-xs text-gray-500 mt-1">Upload gambar baru atau centang "Hapus gambar" untuk kembali ke default</p>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1"
                            {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Tersedia</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Produk Unggulan</span>
                    </label>
                </div>

                <button type="submit"
                    class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Update Produk
                </button>

            </div>
        </form>
    </div>
</div>
@endsection