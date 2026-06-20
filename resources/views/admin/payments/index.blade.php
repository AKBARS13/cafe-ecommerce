@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')

<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Pembayaran Menunggu Verifikasi</h2>
    <p class="text-sm text-gray-500 mt-1">Verifikasi bukti transfer/QRIS dari customer</p>
</div>

@if($pendingPayments->count() > 0)
    <div class="space-y-4">
        @foreach($pendingPayments as $order)
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Info Order --}}
                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-amber-600">{{ $order->order_number }}</h3>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-500">Pelanggan</p>
                                <p class="font-semibold">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Telepon</p>
                                <p class="font-semibold">{{ $order->customer_phone ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Metode Bayar</p>
                                <p class="font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Bayar</p>
                                <p class="font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            @if($order->bankAccount)
                                <div class="col-span-2">
                                    <p class="text-gray-500">Transfer ke</p>
                                    <p class="font-semibold">
                                        {{ $order->bankAccount->bank_name }} - {{ $order->bankAccount->account_number }}
                                        <span class="text-gray-500">({{ $order->bankAccount->account_holder }})</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center space-x-3 mt-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="text-amber-600 hover:text-amber-800 text-sm font-semibold">
                                <i class="fas fa-eye mr-1"></i> Detail Order
                            </a>

                            {{-- Verify Button --}}
                            <form action="{{ route('admin.payments.verify', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    onclick="return confirm('Yakin verifikasi pembayaran ini?')"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition text-sm font-semibold">
                                    <i class="fas fa-check mr-1"></i> Verifikasi (Setujui)
                                </button>
                            </form>

                            {{-- Reject Button (open modal) --}}
                            <button type="button"
                                onclick="openRejectModal({{ $order->id }})"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition text-sm font-semibold">
                                <i class="fas fa-times mr-1"></i> Tolak
                            </button>
                        </div>
                    </div>

                    {{-- Bukti Bayar --}}
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Bukti Pembayaran:</p>
                        @if($order->payment_proof)
                            <a href="{{ $order->payment_proof }}" target="_blank">
                                <img src="{{ $order->payment_proof }}"
                                    class="w-full rounded-lg object-cover border-2 border-gray-200 hover:border-amber-500 transition cursor-pointer"
                                    style="max-height: 200px;">
                            </a>
                            <p class="text-xs text-gray-400 mt-1 text-center">Klik untuk perbesar</p>
                        @else
                            <div class="bg-gray-100 rounded-lg p-8 text-center">
                                <i class="fas fa-image text-gray-300 text-4xl"></i>
                                <p class="text-gray-500 text-sm mt-2">Belum ada bukti</p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Reject Modal --}}
                <div id="rejectModal{{ $order->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                        <h3 class="font-bold text-lg mb-4">Tolak Pembayaran</h3>
                        <form action="{{ route('admin.payments.reject', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan *</label>
                                <textarea name="rejection_reason" rows="3" required
                                    placeholder="Contoh: Bukti transfer tidak jelas, jumlah tidak sesuai..."
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                            </div>
                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" onclick="closeRejectModal({{ $order->id }})"
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition font-semibold">
                                    Tolak Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $pendingPayments->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <i class="fas fa-check-circle text-green-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Tidak ada pembayaran yang menunggu verifikasi</p>
    </div>
@endif

<script>
    function openRejectModal(orderId) {
        document.getElementById('rejectModal' + orderId).classList.remove('hidden');
    }
    function closeRejectModal(orderId) {
        document.getElementById('rejectModal' + orderId).classList.add('hidden');
    }
</script>

@endsection