@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $order->order_number }}</h1>
            <p class="text-gray-500">{{ $order->getFormattedDate() }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    {{-- Alert Payment Status --}}
    @if($order->payment_status === 'pending_verification')
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded-lg">
            <p class="text-yellow-800 font-semibold">
                <i class="fas fa-clock mr-2"></i> Bukti pembayaran sedang diverifikasi admin.
            </p>
        </div>
    @elseif($order->payment_status === 'paid')
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <p class="text-green-800 font-semibold">
                <i class="fas fa-check-circle mr-2"></i> Pembayaran berhasil diverifikasi!
            </p>
        </div>
    @elseif($order->payment_status === 'rejected')
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <p class="text-red-800 font-semibold">
                <i class="fas fa-times-circle mr-2"></i> Bukti pembayaran ditolak.
            </p>
            @if($order->payment_rejection_reason)
                <p class="text-red-700 text-sm mt-1">Alasan: {{ $order->payment_rejection_reason }}</p>
            @endif
            <p class="text-red-700 text-sm mt-1">Silakan upload bukti pembayaran yang baru di bawah.</p>
        </div>
    @endif

    {{-- Upload Bukti Pembayaran --}}
    @if(in_array($order->payment_method, ['transfer', 'e_wallet']) && in_array($order->payment_status, ['unpaid', 'rejected']))
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">
                <i class="fas fa-upload mr-2 text-amber-500"></i> Upload Bukti Pembayaran
            </h2>

            {{-- Info Pembayaran --}}
            @if($order->payment_method === 'transfer' && $order->bankAccount)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600">Transfer ke:</p>
                    <p class="font-bold text-lg">{{ $order->bankAccount->bank_name }}</p>
                    <p class="font-mono text-xl text-blue-700">{{ $order->bankAccount->account_number }}</p>
                    <p class="text-sm">a.n. {{ $order->bankAccount->account_holder }}</p>
                    <p class="font-bold text-amber-600 mt-2">Nominal: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            @elseif($order->payment_method === 'e_wallet' && $cafeSetting->qris_image)
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">Scan QRIS:</p>
                    <img src="{{ $cafeSetting->qris_image }}" class="w-48 h-48 mx-auto rounded-lg">
                    @if($cafeSetting->qris_merchant_name)
                        <p class="font-bold mt-2">{{ $cafeSetting->qris_merchant_name }}</p>
                    @endif
                    <p class="font-bold text-amber-600 mt-2">Nominal: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            @endif

            <form action="{{ route('orders.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Bukti Pembayaran *</label>
                        <input type="file" name="payment_proof" accept="image/*" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (max 5MB)</p>
                        @error('payment_proof')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold">
                        <i class="fas fa-upload mr-2"></i> Upload Bukti
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Bukti Pembayaran Yang Sudah Diupload --}}
    @if($order->payment_proof && $order->payment_status === 'pending_verification')
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Bukti Pembayaran Anda</h2>
            <a href="{{ $order->payment_proof }}" target="_blank">
                <img src="{{ $order->payment_proof }}" class="rounded-lg max-w-sm mx-auto border-2 border-gray-200">
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Informasi Pesanan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Pesanan</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->status_color === 'yellow') bg-yellow-100 text-yellow-800
                        @elseif($order->status_color === 'blue') bg-blue-100 text-blue-800
                        @elseif($order->status_color === 'green') bg-green-100 text-green-800
                        @elseif($order->status_color === 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $order->status_label }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Bayar</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->payment_status_color === 'green') bg-green-100 text-green-800
                        @elseif($order->payment_status_color === 'yellow') bg-yellow-100 text-yellow-800
                        @elseif($order->payment_status_color === 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $order->payment_status_label }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tipe Pesanan</span>
                    <span class="font-semibold">{{ $order->order_type_label }}</span>
                </div>
                @if($order->reservation_date)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Datang</span>
                        <span class="font-semibold">{{ $order->reservation_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jam Datang</span>
                        <span class="font-semibold">{{ date('H:i', strtotime($order->reservation_time)) }}</span>
                    </div>
                @endif
                @if($order->guest_count > 1)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Tamu</span>
                        <span class="font-semibold">{{ $order->guest_count }} orang</span>
                    </div>
                @endif
                @if($order->table_number)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nomor Meja</span>
                        <span class="font-semibold bg-green-100 text-green-800 px-2 py-1 rounded">{{ $order->table_number }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Bayar</span>
                    <span class="font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Informasi Pelanggan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama</span>
                    <span class="font-semibold">{{ $order->customer_name }}</span>
                </div>
                @if($order->customer_phone)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Telepon</span>
                        <span class="font-semibold">{{ $order->customer_phone }}</span>
                    </div>
                @endif
                @if($order->notes)
                    <div>
                        <span class="text-gray-600">Catatan:</span>
                        <p class="font-semibold mt-1">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4">Item Pesanan</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between py-3 border-b last:border-0">
                    <div class="flex items-center space-x-4">
                        @if($item->product && $item->product->image)
                            <img src="{{ $item->product->image }}" class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-mug-hot text-amber-300"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                            @if($item->notes)
                                <p class="text-xs text-gray-400"><i class="fas fa-sticky-note mr-1"></i> {{ $item->notes }}</p>
                            @endif
                        </div>
                    </div>
                    <span class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4">Ringkasan Pembayaran</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">PPN</span>
                <span class="font-semibold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            <hr>
            <div class="flex justify-between text-lg">
                <span class="font-bold text-gray-800">Total Bayar</span>
                <span class="font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

</div>
@endsection