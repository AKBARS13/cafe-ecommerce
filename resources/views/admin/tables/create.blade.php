@extends('layouts.admin')

@section('title', 'Tambah Meja')
@section('page-title', 'Tambah Meja')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.tables.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Meja *</label>
                        <input type="text" name="table_number" value="{{ old('table_number') }}" required
                            placeholder="Contoh: A1, B2, VIP1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @error('table_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas (orang) *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', 4) }}" required min="1" max="20"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi *</label>
                        <select name="location" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="indoor" {{ old('location') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                            <option value="outdoor" {{ old('location') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status *</label>
                        <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Terisi</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Simpan Meja
                </button>

            </div>
        </form>
    </div>
</div>
@endsection