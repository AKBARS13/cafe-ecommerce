@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}"
        class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description', $category->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                    @if($category->image)
                        <div class="mb-2">
                            <img src="{{ $category->image }}"
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

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600">
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>

                <button type="submit"
                    class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Update Kategori
                </button>

            </div>
        </form>
    </div>
</div>
@endsection