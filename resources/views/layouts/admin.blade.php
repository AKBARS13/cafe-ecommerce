<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Cafe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-amber-900 text-white min-h-screen fixed left-0 top-0 z-40 overflow-y-auto">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <i class="fas fa-coffee text-amber-300 text-2xl"></i>
                    <span class="text-lg font-bold">Admin Panel</span>
                </a>
            </div>

            <nav class="mt-6 pb-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.categories.*') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-tags w-5 mr-3"></i> Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.products.*') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-mug-hot w-5 mr-3"></i> Produk
                </a>
                <a href="{{ route('admin.tables.index') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.tables.*') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-chair w-5 mr-3"></i> Meja
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.orders.*') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-receipt w-5 mr-3"></i> Pesanan
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition {{ request()->routeIs('admin.settings.*') ? 'bg-amber-800 border-r-4 border-amber-300' : '' }}">
                    <i class="fas fa-cog w-5 mr-3"></i> Pengaturan
                </a>

                <hr class="border-amber-700 my-4 mx-6">

                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 hover:bg-amber-800 transition">
                    <i class="fas fa-external-link-alt w-5 mr-3"></i> Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-6 py-3 hover:bg-amber-800 transition w-full text-left">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 ml-64">

            {{-- Top Bar --}}
            <div class="bg-white shadow-sm px-8 py-4 flex items-center justify-between sticky top-0 z-30">
                <h1 class="text-lg font-semibold text-gray-700">
                    @yield('page-title', 'Dashboard')
                </h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-user mr-1"></i> {{ Auth::user()->name }}
                    </span>
                </div>
            </div>

            {{-- Flash Messages --}}
            <div class="px-8 pt-4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" id="admin-alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" id="admin-alert">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <div class="p-8">
                @yield('content')
            </div>

        </main>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('admin-alert')?.remove();
        }, 5000);
    </script>
</body>
</html>