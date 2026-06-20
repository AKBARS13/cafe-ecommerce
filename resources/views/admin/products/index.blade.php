@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')

<div class="flex items-center justify-between mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex space-x-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari produk..."
            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
        <select name="category" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <a href="{{ route('admin.products.create') }}"
        class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
        <i class="fas fa-plus mr-2"></i> Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Produk</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Kategori</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Harga</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Stok</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if($product->image)
                                    <img src="{{ $product->image }}"
                                        class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-mug-hot text-amber-300"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 capitalize">{{ $product->type }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">
                            @if($product->has_discount)
                                <span class="line-through text-gray-400 text-xs block">
                                    {{ $product->getFormattedPrice() }}
                                </span>
                                <span class="font-semibold text-amber-600">
                                    {{ $product->formatted_final_price }}
                                </span>
                            @else
                                <span class="font-semibold">{{ $product->getFormattedPrice() }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_available)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    Nonaktif
                                </span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-semibold ml-1">
                                    <i class="fas fa-star"></i>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $products->withQueryString()->links() }}
    </div>
</div>

@endsection