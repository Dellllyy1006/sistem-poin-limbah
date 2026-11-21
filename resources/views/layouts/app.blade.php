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
<body class="min-h-screen flex flex-col bg-[#FAF9F6] text-[#1F2937]">

    <!-- Navbar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-[#E5E7EB] shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('peserta.dashboard') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#F97316] to-[#F59E0B] flex items-center justify-center text-white shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-xl tracking-tight text-[#1F2937]">Eco<span class="text-[#F97316]">Point</span></span>
                            <span class="hidden sm:inline-block ml-2 text-xs font-semibold px-2 py-0.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-emerald-100 text-emerald-800 border border-emerald-300' }}">
                                {{ auth()->user()->isAdmin() ? 'ADMIN' : 'PESERTA' }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-1">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.transactions.*') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Verifikasi Transaksi
                        </a>
                        <a href="{{ route('admin.redemptions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.redemptions.*') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Penukaran Poin
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Kategori Limbah
                        </a>
                    @else
                        <a href="{{ route('peserta.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('peserta.dashboard') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('peserta.transactions.create') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('peserta.transactions.create') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Setor Limbah
                        </a>
                        <a href="{{ route('peserta.transactions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('peserta.transactions.index') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Riwayat Setor
                        </a>
                        <a href="{{ route('peserta.redemptions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('peserta.redemptions.*') ? 'bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                            Tukar Poin
                        </a>
                    @endif
                </nav>

                <!-- User Profile & Action -->
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isPeserta())
                        <div class="flex items-center gap-2 bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200/80 px-3 py-1.5 rounded-full shadow-2xs">
                            <svg class="w-4 h-4 text-[#F97316]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">Saldo:</span>
                            <span class="font-heading font-bold text-sm text-[#F97316]">{{ number_format(auth()->user()->total_points) }} <span class="text-xs font-normal text-gray-500">Poin</span></span>
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
                            <button type="submit" title="Keluar" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
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
                    <a href="{{ route('admin.dashboard') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('admin.dashboard') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Dashboard</a>
                    <a href="{{ route('admin.transactions.index') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('admin.transactions.*') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Transaksi</a>
                    <a href="{{ route('admin.redemptions.index') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('admin.redemptions.*') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Penukaran</a>
                    <a href="{{ route('admin.categories.index') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('admin.categories.*') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Kategori</a>
                @else
                    <a href="{{ route('peserta.dashboard') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('peserta.dashboard') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Dashboard</a>
                    <a href="{{ route('peserta.transactions.create') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('peserta.transactions.create') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Setor</a>
                    <a href="{{ route('peserta.transactions.index') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('peserta.transactions.index') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Riwayat</a>
                    <a href="{{ route('peserta.redemptions.index') }}" class="py-1 px-2 rounded font-medium {{ request()->routeIs('peserta.redemptions.*') ? 'text-[#F97316] font-bold' : 'text-gray-600' }}">Tukar</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-xs">
                <svg class="w-5 h-5 text-[#10B981] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 shadow-xs">
                <svg class="w-5 h-5 text-[#EF4444] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 shadow-xs">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <svg class="w-5 h-5 text-[#EF4444]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Terjadi kesalahan input:
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
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
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} <strong>EcoPoint Monolith</strong> - Sistem Penukaran Poin Limbah (Botol & Kaleng).</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
