@extends('layouts.admin')

@section('title', 'Pengaturan QRIS')
@section('page-title', 'Pengaturan QRIS')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.qris.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <label class="flex items-center mb-4">
                    <input type="checkbox" name="qris_enabled" value="1"
                        {{ old('qris_enabled', $setting->qris_enabled) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 w-5 h-5">
                    <span class="ml-2 text-sm text-gray-700 font-semibold">Aktifkan Pembayaran QRIS</span>
                </label>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Merchant QRIS</label>
                    <input type="text" name="qris_merchant_name" value="{{ old('qris_merchant_name', $setting->qris_merchant_name) }}"
                        placeholder="Contoh: Cafe Kopi Nusantara"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar QR Code QRIS</label>
                    @if($setting->qris_image)
                        <div class="mb-2">
                            <img src="{{ $setting->qris_image }}" class="w-48 h-48 rounded-lg object-cover border-2 border-gray-200 mb-2">
                            <label class="flex items-center text-sm">
                                <input type="checkbox" name="remove_qris" value="1"
                                    class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-red-600">Hapus QR Code</span>
                            </label>
                        </div>
                    @endif
                    <input type="file" name="qris_image" accept="image/*"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-xs text-gray-500 mt-1">Upload gambar QR Code QRIS (PNG, JPG, max 2MB)</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Instruksi Pembayaran</label>
                    <textarea name="qris_instructions" rows="3"
                        placeholder="Contoh: Scan QR code menggunakan aplikasi e-wallet (GoPay, OVO, DANA, ShopeePay, dll). Setelah bayar, upload bukti pembayaran."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('qris_instructions', $setting->qris_instructions) }}</textarea>
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan QRIS
                </button>

            </div>
        </form>
    </div>
</div>
@endsection