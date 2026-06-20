@extends('layouts.admin')

@section('title', 'Edit Rekening Bank')
@section('page-title', 'Edit Rekening Bank')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.bank-accounts.index') }}" class="text-amber-600 hover:text-amber-700 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.bank-accounts.update', $bankAccount) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Bank *</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $bankAccount->bank_name) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('bank_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening *</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $bankAccount->account_number) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Atas Nama *</label>
                    <input type="text" name="account_holder" value="{{ old('account_holder', $bankAccount->account_holder) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan</label>
                    <textarea name="notes" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('notes', $bankAccount->notes) }}</textarea>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan rekening ini</span>
                </label>

                <button type="submit" class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                    <i class="fas fa-save mr-2"></i> Update Rekening
                </button>

            </div>
        </form>
    </div>
</div>
@endsection