@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}"
        class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori *</label>
                        <select name="category_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Diskon</label>
                        <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe *</label>
                        <select name="type" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="drink" {{ old('type') == 'drink' ? 'selected' : '' }}>Minuman</option>
                            <option value="food" {{ old('type') == 'food' ? 'selected' : '' }}>Makanan</option>
                            <option value="snack" {{ old('type') == 'snack' ? 'selected' : '' }}>Snack</option>
                            <option value="dessert" {{ old('type') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1"
                            {{ old('is_available', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Tersedia</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-700">Produk Unggulan</span>
                    </label>
                </div>

                <button type="submit"
                    class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Simpan Produk
                </button>

            </div>
        </form>
    </div>
</div>
@endsection