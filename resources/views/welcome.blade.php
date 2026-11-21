<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint - Sistem Penukaran Poin Limbah</title>

    <!-- Google Fonts: Montserrat & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FAF9F6] text-[#1F2937]">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur border-b border-[#E5E7EB] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#F97316] to-[#F59E0B] flex items-center justify-center text-white shadow-md shadow-orange-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <span class="font-heading font-extrabold text-xl text-[#1F2937]">Eco<span class="text-[#F97316]">Point</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-[#F97316] px-3 py-2 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold px-4 py-2 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white shadow-md shadow-orange-500/20 hover:opacity-95 transition-all">
                        Daftar Peserta
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-[#F97316] text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-[#F97316]"></span>
            EcoPoint Monolith Platform
        </div>
        <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-[#1F2937] tracking-tight max-w-4xl mx-auto leading-tight">
            Tukarkan Limbah <span class="bg-gradient-to-r from-[#F97316] to-[#F59E0B] bg-clip-text text-transparent">Botol & Kaleng</span> Jadi Rupiah
        </h1>
        <p class="mt-6 text-base sm:text-lg text-gray-600 max-w-2xl mx-auto">
            Sistem terintegrasi untuk menyetor sampah bernilai ekonomis, mendapatkan poin berdasarkan kualitas grade kelayakan, dan mencairkannya langsung ke mata uang Rupiah.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white font-heading font-bold text-base shadow-lg shadow-orange-500/25 hover:opacity-95 transition-all">
                Daftar & Mulai Menabung Poin
            </a>
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-white border border-[#E5E7EB] text-gray-800 font-heading font-semibold text-base hover:bg-gray-50 transition-all shadow-xs">
                Masuk ke Akun
            </a>
        </div>
    </section>

    <!-- 3 Pillars Feature Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- 1. Kategori Limbah -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-orange-100 text-[#F97316] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">2 Kategori Khusus</h3>
                <p class="text-sm text-gray-600 mb-4">Sistem difokuskan pada dua jenis limbah bernilai tinggi:</p>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#FAF9F6] border border-gray-100">
                        <span class="font-semibold text-gray-800">Botol Plastik</span>
                        <span class="text-[#F97316] font-bold">1 pcs = 1 Poin</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#FAF9F6] border border-gray-100">
                        <span class="font-semibold text-gray-800">Kaleng Aluminium</span>
                        <span class="text-[#F97316] font-bold">Per 100 gram = 1 Poin</span>
                    </div>
                </div>
            </div>

            <!-- 2. Grade Kelayakan -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#10B981] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">Penilaian Grade (A - D)</h3>
                <p class="text-sm text-gray-600 mb-4">Setiap setoran diverifikasi langsung oleh Admin:</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="p-2 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900">
                        <span class="font-bold block">Grade A (+4 Poin)</span>
                        <span class="text-[10px] text-emerald-700">Sangat Bagus</span>
                    </div>
                    <div class="p-2 rounded-lg bg-blue-50 border border-blue-200 text-blue-900">
                        <span class="font-bold block">Grade B (+3 Poin)</span>
                        <span class="text-[10px] text-blue-700">Bagus</span>
                    </div>
                    <div class="p-2 rounded-lg bg-amber-50 border border-amber-200 text-amber-900">
                        <span class="font-bold block">Grade C (+2 Poin)</span>
                        <span class="text-[10px] text-amber-700">Cukup</span>
                    </div>
                    <div class="p-2 rounded-lg bg-red-50 border border-red-200 text-red-900">
                        <span class="font-bold block">Grade D (+1 Poin)</span>
                        <span class="text-[10px] text-red-700">Kurang Layak</span>
                    </div>
                </div>
            </div>

            <!-- 3. Konversi Rupiah Greedy -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-[#F59E0B] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">Konversi Greedy Rupiah</h3>
                <p class="text-sm text-gray-600 mb-4">Penukaran poin menggunakan pecahan greedy terbaik:</p>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-orange-50/50 border border-orange-100">
                        <span class="font-semibold text-gray-700">20 Poin</span>
                        <span class="font-bold text-[#F97316]">Rp 1.000</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-orange-50/50 border border-orange-100">
                        <span class="font-semibold text-gray-700">10 Poin</span>
                        <span class="font-bold text-[#F97316]">Rp 500</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-orange-50/50 border border-orange-100">
                        <span class="font-semibold text-gray-700">1 Poin</span>
                        <span class="font-bold text-[#F97316]">Rp 100</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#E5E7EB] py-8 text-center text-xs text-gray-500">
        <p>&copy; {{ date('Y') }} <strong>EcoPoint Monolith</strong>. Memenuhi seluruh aturan PRD, ERD, dan Design System.</p>
    </footer>

</body>
</html>
