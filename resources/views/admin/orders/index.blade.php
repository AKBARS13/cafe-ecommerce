@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')

<div class="flex items-center space-x-4 mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex space-x-2">
        <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <select name="payment_status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
            <option value="">Semua Pembayaran</option>
            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
        </select>
        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">No. Order</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Pelanggan</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Tipe</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Total</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Bayar</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-amber-600">
                            {{ $order->order_number }}
                        </td>
                        <td class="px-6 py-4">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">
                            {{ $order->order_type === 'dine_in' ? 'Dine In' : 'Takeaway' }}
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($order->status_color === 'yellow') bg-yellow-100 text-yellow-800
                                @elseif($order->status_color === 'blue') bg-blue-100 text-blue-800
                                @elseif($order->status_color === 'indigo') bg-indigo-100 text-indigo-800
                                @elseif($order->status_color === 'green') bg-green-100 text-green-800
                                @elseif($order->status_color === 'red') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $order->payment_status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->getFormattedDate() }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="text-amber-600 hover:text-amber-800 font-semibold text-sm">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-receipt text-gray-300 text-4xl mb-2"></i>
                            <p>Belum ada pesanan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>

@endsection