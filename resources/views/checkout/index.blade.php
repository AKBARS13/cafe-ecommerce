@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-credit-card text-amber-500 mr-2"></i> Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Info --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-user mr-2 text-amber-500"></i> Informasi Pelanggan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama *</label>
                            <input type="text" name="customer_name" value="{{ Auth::user()->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                            <input type="text" name="customer_phone" value="{{ Auth::user()->phone }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>
                </div>

                {{-- Order Type --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-store mr-2 text-amber-500"></i> Tipe Pesanan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="dine_in" checked class="sr-only peer" onchange="toggleOrderType(this.value)">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                <i class="fas fa-chair text-2xl text-amber-600 mb-2"></i>
                                <p class="font-semibold">Makan di Tempat</p>
                                <p class="text-xs text-gray-500 mt-1">Hari ini saja</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="order_type" value="takeaway" class="sr-only peer" onchange="toggleOrderType(this.value)">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                <i class="fas fa-shopping-bag text-2xl text-amber-600 mb-2"></i>
                                <p class="font-semibold">Takeaway</p>
                                <p class="text-xs text-gray-500 mt-1">Ambil di cafe</p>
                            </div>
                        </label>
                        @if($cafeSetting->accept_reservation)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="order_type" value="reservation" class="sr-only peer" onchange="toggleOrderType(this.value)">
                                <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                    <i class="fas fa-calendar-check text-2xl text-amber-600 mb-2"></i>
                                    <p class="font-semibold">Reservasi</p>
                                    <p class="text-xs text-gray-500 mt-1">Pesan jauh-jauh hari</p>
                                </div>
                            </label>
                        @endif
                    </div>
                </div>

                {{-- Jadwal --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-clock mr-2 text-amber-500"></i> Jadwal
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal *</label>
                            <input type="date" name="reservation_date" id="reservation_date"
                                value="{{ now()->format('Y-m-d') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam *</label>
                            <input type="time" name="reservation_time" id="reservation_time"
                                value="{{ now()->format('H:i') }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <p class="text-xs text-gray-500 mt-1" id="time-info">Jam buka: {{ $cafeSetting->formatted_open_time }} - {{ $cafeSetting->formatted_close_time }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="1" min="1" max="20"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>
                </div>

                {{-- Info Meja Tersedia --}}
                <div class="bg-white rounded-xl shadow-md p-6" id="tables-info">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-chair mr-2 text-amber-500"></i> Meja Tersedia
                    </h2>
                    <p class="text-sm text-gray-500 mb-4">Admin akan assign meja saat pesanan dikonfirmasi.</p>

                    @if($availableTables->count() > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                            @foreach($availableTables as $table)
                                <div class="border-2 border-green-500 bg-green-50 rounded-xl p-3 text-center">
                                    <i class="fas fa-chair text-2xl text-green-600"></i>
                                    <p class="font-bold text-gray-800 mt-1 text-sm">{{ $table->table_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $table->capacity }} orang</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-500 text-sm">Saat ini tidak ada meja tersedia.</p>
                    @endif
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-wallet mr-2 text-amber-500"></i> Metode Pembayaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" checked class="sr-only peer" onchange="togglePaymentMethod(this.value)">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                <i class="fas fa-money-bill-wave text-2xl text-green-600 mb-2"></i>
                                <p class="font-semibold text-sm">Tunai</p>
                            </div>
                        </label>
                        @if($bankAccounts->count() > 0)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer" class="sr-only peer" onchange="togglePaymentMethod(this.value)">
                                <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                    <i class="fas fa-university text-2xl text-blue-600 mb-2"></i>
                                    <p class="font-semibold text-sm">Transfer Bank</p>
                                </div>
                            </label>
                        @endif
                        @if($cafeSetting->qris_enabled && $cafeSetting->qris_image)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="e_wallet" class="sr-only peer" onchange="togglePaymentMethod(this.value)">
                                <div class="border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                    <i class="fas fa-qrcode text-2xl text-purple-600 mb-2"></i>
                                    <p class="font-semibold text-sm">QRIS</p>
                                </div>
                            </label>
                        @endif
                    </div>

                    {{-- Pilih Bank (kalau transfer) --}}
                    <div id="bank-options" class="mt-4 hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Rekening Tujuan *</label>
                        <div class="space-y-2">
                            @foreach($bankAccounts as $bank)
                                <label class="block border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-amber-500">
                                    <input type="radio" name="bank_account_id" value="{{ $bank->id }}" class="sr-only peer">
                                    <div class="peer-checked:font-bold flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold">{{ $bank->bank_name }}</p>
                                            <p class="text-sm text-gray-600 font-mono">{{ $bank->account_number }}</p>
                                            <p class="text-xs text-gray-500">a.n. {{ $bank->account_holder }}</p>
                                        </div>
                                        <i class="fas fa-circle text-gray-300"></i>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-amber-600 mt-2">
                            <i class="fas fa-info-circle"></i> Setelah pesan, kamu perlu upload bukti transfer.
                        </p>
                    </div>

                    {{-- QRIS Info --}}
                    <div id="qris-info" class="mt-4 hidden">
                        @if($cafeSetting->qris_image)
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Scan QRIS untuk Bayar</p>
                                <img src="{{ $cafeSetting->qris_image }}" class="w-48 h-48 mx-auto rounded-lg">
                                @if($cafeSetting->qris_merchant_name)
                                    <p class="text-sm font-bold mt-2">{{ $cafeSetting->qris_merchant_name }}</p>
                                @endif
                                <p class="text-xs text-amber-600 mt-2">
                                    <i class="fas fa-info-circle"></i> Setelah pesan, kamu perlu upload bukti pembayaran.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-sticky-note mr-2 text-amber-500"></i> Catatan Tambahan
                    </h2>
                    <textarea name="notes" rows="3" placeholder="Catatan khusus untuk pesanan Anda..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                </div>

            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-4">

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">PPN (10%)</span>
                            <span class="font-semibold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold text-gray-800">Total Bayar</span>
                            <span class="font-bold text-amber-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-amber-600 text-white py-3 rounded-xl hover:bg-amber-500 transition font-bold text-lg">
                        <i class="fas fa-check-circle mr-2"></i> Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}" class="block mt-3 text-center text-amber-600 hover:text-amber-700 font-semibold text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    const cafeSetting = {
        openTime: "{{ $cafeSetting->formatted_open_time }}",
        closeTime: "{{ $cafeSetting->formatted_close_time }}",
        reservationStart: "{{ date('H:i', strtotime($cafeSetting->reservation_start_time)) }}",
        reservationEnd: "{{ date('H:i', strtotime($cafeSetting->reservation_end_time)) }}",
        maxReservationDays: {{ $cafeSetting->max_reservation_days }},
    };

    const today = new Date().toISOString().split('T')[0];
    const maxReservationDate = new Date();
    maxReservationDate.setDate(maxReservationDate.getDate() + cafeSetting.maxReservationDays);
    const maxReservationDateStr = maxReservationDate.toISOString().split('T')[0];

    function toggleOrderType(type) {
        const dateInput = document.getElementById('reservation_date');
        const timeInput = document.getElementById('reservation_time');
        const timeInfo = document.getElementById('time-info');
        const tablesInfo = document.getElementById('tables-info');

        if (type === 'reservation') {
            dateInput.min = today;
            dateInput.max = maxReservationDateStr;
            timeInput.min = cafeSetting.reservationStart;
            timeInput.max = cafeSetting.reservationEnd;
            timeInfo.innerText = `Jam reservasi: ${cafeSetting.reservationStart} - ${cafeSetting.reservationEnd}`;
            tablesInfo.style.display = 'block';
        } else if (type === 'dine_in') {
            dateInput.min = today;
            dateInput.max = today;
            dateInput.value = today;
            timeInput.min = cafeSetting.openTime;
            timeInput.max = cafeSetting.closeTime;
            timeInfo.innerText = `Jam buka: ${cafeSetting.openTime} - ${cafeSetting.closeTime}`;
            tablesInfo.style.display = 'block';
        } else {
            dateInput.min = today;
            dateInput.max = today;
            dateInput.value = today;
            timeInput.min = cafeSetting.openTime;
            timeInput.max = cafeSetting.closeTime;
            timeInfo.innerText = `Jam buka: ${cafeSetting.openTime} - ${cafeSetting.closeTime}`;
            tablesInfo.style.display = 'none';
        }
    }

    function togglePaymentMethod(method) {
        const bankOptions = document.getElementById('bank-options');
        const qrisInfo = document.getElementById('qris-info');

        bankOptions.classList.add('hidden');
        qrisInfo.classList.add('hidden');

        if (method === 'transfer') {
            bankOptions.classList.remove('hidden');
        } else if (method === 'e_wallet') {
            qrisInfo.classList.remove('hidden');
        }
    }

    toggleOrderType('dine_in');
</script>
@endsection