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
<body class="min-h-screen flex flex-col justify-center items-center p-4 bg-[#FAFAFB] text-[#1F2937] relative overflow-x-hidden antialiased selection:bg-red-500 selection:text-white">

    <!-- Ambient Glowing Red Backdrop -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-gradient-to-br from-red-500/15 via-rose-500/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 right-10 w-[500px] h-[500px] bg-gradient-to-tr from-rose-500/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Branding -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 flex items-center justify-center text-white shadow-lg shadow-red-500/30 group-hover:scale-105 group-hover:shadow-red-500/45 transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div class="text-left">
                    <span class="font-heading font-extrabold text-2xl tracking-tight text-[#1F2937]">Eco<span class="text-red-600">Point</span></span>
                    <span class="block text-xs text-gray-500 font-medium">Sistem Penukaran Poin Limbah</span>
                </div>
            </a>
        </div>

        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium shadow-xs">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium shadow-xs">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

        <!-- Footer Link -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-red-600 font-semibold transition-colors inline-flex items-center gap-1">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
