@extends('layouts.admin')

@section('title', 'Kelola Meja')
@section('page-title', 'Kelola Meja')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Meja</h2>
    <a href="{{ route('admin.tables.create') }}"
        class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-500 transition font-semibold">
        <i class="fas fa-plus mr-2"></i> Tambah Meja
    </a>
</div>

{{-- Visual Grid Meja --}}
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">Tampilan Visual Meja</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($tables as $table)
            <div class="border-2 rounded-xl p-4 text-center
                @if($table->status_color === 'green') border-green-500 bg-green-50
                @elseif($table->status_color === 'red') border-red-500 bg-red-50
                @elseif($table->status_color === 'yellow') border-yellow-500 bg-yellow-50
                @else border-gray-400 bg-gray-50
                @endif">
                <i class="fas fa-chair text-3xl
                    @if($table->status_color === 'green') text-green-600
                    @elseif($table->status_color === 'red') text-red-600
                    @elseif($table->status_color === 'yellow') text-yellow-600
                    @else text-gray-600
                    @endif"></i>
                <p class="font-bold text-gray-800 mt-2">{{ $table->table_number }}</p>
                <p class="text-xs text-gray-500">{{ $table->capacity }} orang</p>
                <p class="text-xs font-semibold mt-1
                    @if($table->status_color === 'green') text-green-700
                    @elseif($table->status_color === 'red') text-red-700
                    @elseif($table->status_color === 'yellow') text-yellow-700
                    @else text-gray-700
                    @endif">
                    {{ $table->status_label }}
                </p>
            </div>
        @endforeach
    </div>
</div>

{{-- Tabel Meja --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Nomor Meja</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Kapasitas</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Quick Status</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800">
                            <i class="fas fa-chair text-amber-500 mr-2"></i>{{ $table->table_number }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $table->capacity }} orang</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                            {{ $table->location_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($table->status_color === 'green') bg-green-100 text-green-800
                            @elseif($table->status_color === 'red') bg-red-100 text-red-800
                            @elseif($table->status_color === 'yellow') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $table->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.tables.updateStatus', $table) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="available" {{ $table->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="occupied" {{ $table->status == 'occupied' ? 'selected' : '' }}>Terisi</option>
                                <option value="reserved" {{ $table->status == 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                <option value="maintenance" {{ $table->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.tables.edit', $table) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" onsubmit="return confirm('Hapus meja ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4">
        {{ $tables->links() }}
    </div>
</div>

@endsection