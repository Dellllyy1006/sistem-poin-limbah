<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Masuk' }} - EcoPoint</title>

    <!-- Google Fonts: Montserrat & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-center items-center p-4 bg-[#FAF9F6] text-[#1F2937]">

    <div class="w-full max-w-md">
        <!-- Logo Branding -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#F97316] to-[#F59E0B] flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-105 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div class="text-left">
                    <span class="font-heading font-extrabold text-2xl tracking-tight text-[#1F2937]">Eco<span class="text-[#F97316]">Point</span></span>
                    <span class="block text-xs text-gray-500 font-medium">Sistem Penukaran Poin Limbah</span>
                </div>
            </a>
        </div>

        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

        <!-- Footer Link -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#F97316] font-medium transition-colors">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
