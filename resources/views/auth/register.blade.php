@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-8">
            <i class="fas fa-coffee text-amber-600 text-5xl mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-800">Buat Akun</h1>
            <p class="text-gray-500 mt-2">Daftar untuk mulai memesan</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('name') border-red-500 @enderror"
                            placeholder="Nama lengkap Anda">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('email') border-red-500 @enderror"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon (opsional)</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            placeholder="0812xxxxxxxx">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            placeholder="Ulangi password">
                    </div>

                    <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                        <i class="fas fa-user-plus mr-2"></i> Daftar
                    </button>

                </div>
            </form>

            <p class="text-center text-gray-500 text-sm mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
                    Login di sini
                </a>
            </p>
        </div>

    </div>
</div>
@endsection