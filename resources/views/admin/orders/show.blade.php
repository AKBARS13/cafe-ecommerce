@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<a href="{{ route('admin.orders.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
    <i class="fas fa-arrow-left mr-1"></i> Kembali
</a>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-2 space-y-6">

        {{-- Update Status --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Update Status Pesanan</h2>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                @method('PUT')
                <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Siap</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
                    <i class="fas fa-save mr-1"></i> Update
                </button>
            </form>
        </div>

        {{-- Assign Meja (kalau dine_in atau reservation) --}}
        @if(in_array($order->order_type, ['dine_in', 'reservation']) && !in_array($order->status, ['completed', 'cancelled']))
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="font-bold text-lg text-gray-800 mb-4">
                    <i class="fas fa-chair mr-2 text-amber-500"></i> Assign Meja
                </h2>

                @if($order->table_number)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <p class="text-green-800 font-semibold">
                            <i class="fas fa-check-circle mr-2"></i> Meja saat ini: <strong>{{ $order->table_number }}</strong>
                        </p>
                        <form action="{{ route('admin.orders.releaseTable', $order->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin kosongkan meja?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                <i class="fas fa-times mr-1"></i> Kosongkan Meja
                            </button>
                        </form>
                    </div>
                @endif

                @if($availableTables->count() > 0)
                    <form action="{{ route('admin.orders.assignTable', $order->id) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PUT')
                        <select name="table_id" required class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">Pilih Meja...</option>
                            @foreach($availableTables as $table)
                                <option value="{{ $table->id }}">
                                    Meja {{ $table->table_number }} ({{ $table->capacity }} orang - {{ $table->location_label }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
                            <i class="fas fa-check mr-1"></i> Assign
                        </button>
                    </form>
                @else
                    <p class="text-red-500 text-sm">Tidak ada meja tersedia saat ini.</p>
                @endif
            </div>
        @endif

        {{-- Order Items --}}
        <div class="bg-white rounded-xl shadow-md p-6">
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
                                <p class="font-semibold">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                @if($item->notes)
                                    <p class="text-xs text-gray-400"><i class="fas fa-sticky-note mr-1"></i> {{ $item->notes }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="space-y-6">

        {{-- Order Info --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Info Pesanan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">No. Order</span>
                    <span class="font-semibold">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tipe</span>
                    <span class="font-semibold">{{ $order->order_type_label }}</span>
                </div>
                @if($order->reservation_date)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal</span>
                        <span class="font-semibold">{{ $order->reservation_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jam</span>
                        <span class="font-semibold">{{ date('H:i', strtotime($order->reservation_time)) }}</span>
                    </div>
                @endif
                @if($order->guest_count > 1)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Tamu</span>
                        <span class="font-semibold">{{ $order->guest_count }} orang</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
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
                    <span class="text-gray-600">Pembayaran</span>
                    <span class="font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Bayar</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $order->payment_status_label }}
                    </span>
                </div>
                @if($order->table_number)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Meja</span>
                        <span class="font-semibold">{{ $order->table_number }}</span>
                    </div>
                @endif
                <hr>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pelanggan</span>
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

        {{-- Payment Summary --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="font-bold text-lg text-gray-800 mb-4">Ringkasan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">PPN</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="flex justify-between text-lg">
                    <span class="font-bold">Total</span>
                    <span class="font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection