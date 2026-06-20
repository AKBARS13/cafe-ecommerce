@extends('layouts.admin')

@section('title', 'Kelola Rekening Bank')
@section('page-title', 'Kelola Rekening Bank')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Rekening Bank untuk Transfer</h2>
    <a href="{{ route('admin.bank-accounts.create') }}"
        class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
        <i class="fas fa-plus mr-2"></i> Tambah Rekening
    </a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Bank</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Nomor Rekening</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Atas Nama</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bankAccounts as $account)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-university text-amber-500"></i>
                            <span class="font-bold text-gray-800">{{ $account->bank_name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono">{{ $account->account_number }}</td>
                    <td class="px-6 py-4">{{ $account->account_holder }}</td>
                    <td class="px-6 py-4">
                        @if($account->is_active)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                Aktif
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-university text-gray-300 text-4xl mb-2"></i>
                        <p>Belum ada rekening bank. Tambahkan rekening untuk metode transfer.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $bankAccounts->links() }}
    </div>
</div>

@endsection