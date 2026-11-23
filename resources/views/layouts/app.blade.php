<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'EcoPoint' }} - Sistem Poin Limbah</title>

    <!-- Google Fonts: Montserrat (Heading) & Poppins (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#FAFAFB] text-[#1F2937] antialiased selection:bg-red-500 selection:text-white">

    <!-- Navbar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#E5E7EB] shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('peserta.dashboard') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 flex items-center justify-center text-white shadow-md shadow-red-500/30 group-hover:scale-105 group-hover:shadow-red-500/40 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-xl tracking-tight text-[#1F2937]">Eco<span class="text-red-600">Point</span></span>
                            <span class="hidden sm:inline-block ml-2 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                {{ auth()->user()->isAdmin() ? 'Admin' : 'Peserta' }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-1.5">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Verifikasi Transaksi
                        </a>
                        <a href="{{ route('admin.redemptions.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.redemptions.*') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Penukaran Poin
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Kategori Limbah
                        </a>
                    @else
                        <a href="{{ route('peserta.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('peserta.dashboard') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('peserta.transactions.create') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('peserta.transactions.create') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Setor Limbah
                        </a>
                        <a href="{{ route('peserta.transactions.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('peserta.transactions.index') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Riwayat Setor
                        </a>
                        <a href="{{ route('peserta.redemptions.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('peserta.redemptions.*') ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                            Tukar Poin
                        </a>
                    @endif
                </nav>

                <!-- User Profile & Action -->
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isPeserta())
                        <div class="flex items-center gap-2 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200/90 px-3.5 py-1.5 rounded-full shadow-2xs hover:border-red-300 transition-colors">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            <span class="text-xs font-semibold text-gray-600">Saldo:</span>
                            <span class="font-heading font-bold text-sm text-red-600">{{ number_format(auth()->user()->total_points) }} <span class="text-xs font-normal text-gray-500">Poin</span></span>
                        </div>
                    @endif

                    <div class="flex items-center gap-2 pl-2 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-semibold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-500 leading-tight">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Keluar" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden border-t border-gray-100 py-2.5 flex items-center justify-around text-xs">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Dashboard</a>
                    <a href="{{ route('admin.transactions.index') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.transactions.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Transaksi</a>
                    <a href="{{ route('admin.redemptions.index') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.redemptions.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Penukaran</a>
                    <a href="{{ route('admin.categories.index') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Kategori</a>
                @else
                    <a href="{{ route('peserta.dashboard') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('peserta.dashboard') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Dashboard</a>
                    <a href="{{ route('peserta.transactions.create') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('peserta.transactions.create') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Setor</a>
                    <a href="{{ route('peserta.transactions.index') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('peserta.transactions.index') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Riwayat</a>
                    <a href="{{ route('peserta.redemptions.index') }}" class="py-1 px-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('peserta.redemptions.*') ? 'text-red-600 font-bold bg-red-50' : 'text-gray-600' }}">Tukar</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-xs animate-fadeIn">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-xs animate-fadeIn">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-xs animate-fadeIn">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1 text-red-700">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Terjadi kesalahan input:
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto bg-white border-t border-[#E5E7EB] py-6 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} <strong class="text-gray-800">EcoPoint Monolith</strong> - Sistem Penukaran Poin Limbah (Botol & Kaleng).</p>
            <div class="flex items-center gap-2 text-[11px] text-gray-400">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span>Red Edition &bull; Monolith Blade</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
