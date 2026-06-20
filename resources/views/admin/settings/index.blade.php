@extends('layouts.admin')

@section('title', 'Pengaturan Cafe')
@section('page-title', 'Pengaturan Cafe')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                {{-- Info Cafe --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-store mr-2 text-amber-500"></i> Informasi Cafe</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Cafe *</label>
                            <input type="text" name="cafe_name" value="{{ old('cafe_name', $setting->cafe_name) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('cafe_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Cafe</label>
                            <textarea name="cafe_description" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('cafe_description', $setting->cafe_description) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di footer website</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                            <textarea name="cafe_address" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('cafe_address', $setting->cafe_address) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" name="cafe_phone" value="{{ old('cafe_phone', $setting->cafe_phone) }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <input type="email" name="cafe_email" value="{{ old('cafe_email', $setting->cafe_email) }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Jam Operasional Weekday --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-clock mr-2 text-amber-500"></i> Jam Operasional (Senin - Jumat)</h3>
                    <p class="text-sm text-gray-500 mb-4">Jam ini berlaku untuk pesanan <strong>Dine-in</strong> dan <strong>Takeaway</strong> di hari kerja.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka *</label>
                            <input type="time" name="open_time" value="{{ old('open_time', date('H:i', strtotime($setting->open_time))) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('open_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tutup *</label>
                            <input type="time" name="close_time" value="{{ old('close_time', date('H:i', strtotime($setting->close_time))) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('close_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Jam Operasional Weekend --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-calendar-week mr-2 text-amber-500"></i> Jam Operasional (Sabtu - Minggu)</h3>
                    <p class="text-sm text-gray-500 mb-4">Khusus untuk akhir pekan. Kosongkan kalau sama dengan weekday.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka Weekend</label>
                            <input type="time" name="weekend_open_time" value="{{ old('weekend_open_time', $setting->weekend_open_time ? date('H:i', strtotime($setting->weekend_open_time)) : '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tutup Weekend</label>
                            <input type="time" name="weekend_close_time" value="{{ old('weekend_close_time', $setting->weekend_close_time ? date('H:i', strtotime($setting->weekend_close_time)) : '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Pengaturan Reservasi --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-calendar-check mr-2 text-amber-500"></i> Pengaturan Reservasi</h3>

                    <label class="flex items-center mb-4">
                        <input type="checkbox" name="accept_reservation" value="1"
                            {{ old('accept_reservation', $setting->accept_reservation) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 w-5 h-5">
                        <span class="ml-2 text-sm text-gray-700 font-semibold">Terima Reservasi</span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Reservasi Mulai Jam *</label>
                            <input type="time" name="reservation_start_time" value="{{ old('reservation_start_time', date('H:i', strtotime($setting->reservation_start_time))) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <p class="text-xs text-gray-500 mt-1">Set 00:00 untuk 24 jam</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Reservasi Sampai Jam *</label>
                            <input type="time" name="reservation_end_time" value="{{ old('reservation_end_time', date('H:i', strtotime($setting->reservation_end_time))) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <p class="text-xs text-gray-500 mt-1">Set 23:59 untuk 24 jam</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Hari ke Depan untuk Reservasi *</label>
                        <input type="number" name="max_reservation_days" value="{{ old('max_reservation_days', $setting->max_reservation_days) }}" required min="1" max="30"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="text-xs text-gray-500 mt-1">Customer bisa reservasi untuk X hari ke depan</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>

            </div>
        </form>
    </div>
</div>
@endsection