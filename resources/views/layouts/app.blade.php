<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cafe Kopi Nusantara') - E-Commerce Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-amber-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <i class="fas fa-coffee text-amber-300 text-2xl"></i>
                    <span class="text-xl font-bold">{{ $cafeSetting->cafe_name ?? 'Cafe Kopi Nusantara' }}</span>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-amber-300 transition {{ request()->routeIs('home') ? 'text-amber-300' : '' }}">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('products.*') ? 'text-amber-300' : '' }}">
                        <i class="fas fa-utensils mr-1"></i> Menu
                    </a>

                    @auth
                        <a href="{{ route('cart.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('cart.*') ? 'text-amber-300' : '' }}">
                            <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                        </a>
                        <a href="{{ route('orders.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('orders.*') ? 'text-amber-300' : '' }}">
                            <i class="fas fa-receipt mr-1"></i> Pesanan
                        </a>

                        {{-- User Dropdown --}}
                        <div class="relative">
                            <button id="user-menu-btn" class="flex items-center space-x-1 hover:text-amber-300 transition">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-amber-50">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Panel
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-amber-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-amber-600 px-4 py-2 rounded-lg hover:bg-amber-500 transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="border border-amber-300 px-4 py-2 rounded-lg hover:bg-amber-800 transition">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden hidden bg-amber-800 pb-4">
            <div class="px-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 hover:text-amber-300">Beranda</a>
                <a href="{{ route('products.index') }}" class="block py-2 hover:text-amber-300">Menu</a>
                @auth
                    <a href="{{ route('cart.index') }}" class="block py-2 hover:text-amber-300">Keranjang</a>
                    <a href="{{ route('orders.index') }}" class="block py-2 hover:text-amber-300">Pesanan</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 hover:text-amber-300">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block py-2 hover:text-amber-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 hover:text-amber-300">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 hover:text-amber-300">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between" id="alert-success">
                <span><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</span>
                <button onclick="document.getElementById('alert-success').remove()" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between" id="alert-error">
                <span><i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}</span>
                <button onclick="document.getElementById('alert-error').remove()" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
<footer class="bg-amber-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold mb-4">
                    <i class="fas fa-coffee mr-2"></i>{{ $cafeSetting->cafe_name ?? 'Cafe Kopi Nusantara' }}
                </h3>
                <p class="text-amber-200 text-sm">
                    {{ $cafeSetting->cafe_description ?? 'Menyajikan kopi dan makanan terbaik dengan cita rasa nusantara.' }}
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Jam Buka</h3>
                <p class="text-amber-200 text-sm">
                    Senin - Jumat: {{ $cafeSetting->formatted_open_time ?? '08:00' }} - {{ $cafeSetting->formatted_close_time ?? '22:00' }}
                </p>
                <p class="text-amber-200 text-sm">
                    Sabtu - Minggu: {{ $cafeSetting->formatted_weekend_open_time ?? '08:00' }} - {{ $cafeSetting->formatted_weekend_close_time ?? '23:00' }}
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Kontak</h3>
                @if($cafeSetting->cafe_address ?? null)
                    <p class="text-amber-200 text-sm"><i class="fas fa-map-marker-alt mr-2"></i> {{ $cafeSetting->cafe_address }}</p>
                @endif
                @if($cafeSetting->cafe_phone ?? null)
                    <p class="text-amber-200 text-sm"><i class="fas fa-phone mr-2"></i> {{ $cafeSetting->cafe_phone }}</p>
                @endif
                @if($cafeSetting->cafe_email ?? null)
                    <p class="text-amber-200 text-sm"><i class="fas fa-envelope mr-2"></i> {{ $cafeSetting->cafe_email }}</p>
                @endif
            </div>
        </div>
        <div class="border-t border-amber-700 mt-8 pt-4 text-center text-amber-300 text-sm">
            <p>&copy; {{ date('Y') }} {{ $cafeSetting->cafe_name ?? 'Cafe Kopi Nusantara' }}. All rights reserved.</p>
        </div>
    </div>
</footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // User dropdown toggle (klik untuk buka/tutup)
        document.getElementById('user-menu-btn')?.addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('user-menu-dropdown').classList.toggle('hidden');
        });

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function(e) {
            let dropdown = document.getElementById('user-menu-dropdown');
            let btn = document.getElementById('user-menu-btn');
            if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Auto hide alerts
        setTimeout(() => {
            document.getElementById('alert-success')?.remove();
            document.getElementById('alert-error')?.remove();
        }, 5000);
    </script>
</body>
</html>