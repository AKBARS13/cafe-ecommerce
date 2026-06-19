@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-8">
            <i class="fas fa-coffee text-amber-600 text-5xl mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-500 mt-2">Masuk ke akun Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('email') border-red-500 @enderror"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg hover:bg-amber-500 transition font-bold">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>

                </div>
            </form>

            <p class="text-center text-gray-500 text-sm mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
                    Daftar di sini
                </a>
            </p>
        </div>

    </div>
</div>
@endsection