<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint - Sistem Penukaran Poin Limbah</title>

    <!-- Google Fonts: Montserrat & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FAFAFB] text-[#1F2937] antialiased selection:bg-red-500 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Glowing Red Backdrop Orbs -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-gradient-to-b from-red-500/15 via-rose-500/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute top-[40%] -right-40 w-[600px] h-[600px] bg-gradient-to-tr from-rose-500/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 -left-40 w-[500px] h-[500px] bg-gradient-to-tr from-red-600/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-[#E5E7EB] sticky top-0 z-50 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 via-rose-600 to-red-700 flex items-center justify-center text-white shadow-md shadow-red-500/30 group-hover:scale-105 group-hover:shadow-red-500/40 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <span class="font-heading font-extrabold text-xl text-[#1F2937]">Eco<span class="text-red-600">Point</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-red-600 px-3.5 py-2 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-heading font-bold px-4 py-2 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white shadow-md shadow-red-500/30 hover:opacity-95 hover:shadow-red-500/40 active:scale-[0.98] transition-all duration-200">
                        Daftar Peserta
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-20 text-center relative z-10">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-50 border border-red-200/80 text-red-700 text-xs font-semibold mb-6 shadow-2xs hover:bg-red-100/70 transition-colors">
            <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
            EcoPoint Platform &bull; Daur Ulang Bernilai Rupiah
        </div>

        <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-[#1F2937] tracking-tight max-w-4xl mx-auto leading-tight">
            Tukarkan Sampah <span class="bg-gradient-to-r from-red-600 via-rose-600 to-red-700 bg-clip-text text-transparent">Botol & Kaleng</span> Jadi Tabungan Rupiah
        </h1>

        <p class="mt-6 text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Platform berbasis monolitik terpercaya untuk menyetor sampah daur ulang, dinilai secara objektif dengan Grade kelayakan, dan dikonversi langsung ke uang Rupiah melalui algoritma greedy pecahan tertinggi.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white font-heading font-bold text-base shadow-lg shadow-red-500/30 hover:opacity-95 hover:shadow-red-500/40 active:scale-[0.98] transition-all duration-200">
                Mulai Setor & Kumpulkan Poin
            </a>
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-white border border-[#E5E7EB] text-gray-800 font-heading font-semibold text-base hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs">
                Masuk ke Akun
            </a>
        </div>

        <!-- Highlight Stats Banner -->
        <div class="mt-14 max-w-3xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-white/80 backdrop-blur-md border border-gray-200/80 shadow-xs">
            <div class="p-2">
                <span class="font-heading font-black text-2xl text-red-600">2 Jenis</span>
                <p class="text-xs text-gray-500 mt-0.5">Botol & Kaleng</p>
            </div>
            <div class="p-2 border-l border-gray-100">
                <span class="font-heading font-black text-2xl text-rose-600">4 Grade</span>
                <p class="text-xs text-gray-500 mt-0.5">Penilaian A / B / C / D</p>
            </div>
            <div class="p-2 border-l border-gray-100">
                <span class="font-heading font-black text-2xl text-red-600">Greedy</span>
                <p class="text-xs text-gray-500 mt-0.5">Pecahan 20, 10, 1 Poin</p>
            </div>
            <div class="p-2 border-l border-gray-100">
                <span class="font-heading font-black text-2xl text-emerald-600">100%</span>
                <p class="text-xs text-gray-500 mt-0.5">Aman & Terverifikasi</p>
            </div>
        </div>
    </section>

    <!-- 3 Pillars Feature Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <div class="text-center mb-10">
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Bagaimana EcoPoint Bekerja?</h2>
            <p class="text-sm text-gray-500 mt-2">Tiga pilar utama sistem yang transparan, mudah, dan menguntungkan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- 1. Kategori Limbah -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-xl hover:shadow-red-500/10 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-red-600 to-rose-600 text-white flex items-center justify-center mb-4 shadow-md shadow-red-500/25">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">2 Kategori Khusus</h3>
                <p class="text-sm text-gray-600 mb-4">Sistem difokuskan pada dua jenis limbah bernilai tinggi:</p>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100">
                        <span class="font-semibold text-gray-800">Botol Plastik</span>
                        <span class="text-red-600 font-bold">1 pcs = 1 Poin</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100">
                        <span class="font-semibold text-gray-800">Kaleng Aluminium</span>
                        <span class="text-red-600 font-bold">Per 100 gram = 1 Poin</span>
                    </div>
                </div>
            </div>

            <!-- 2. Grade Kelayakan -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-xl hover:shadow-rose-500/10 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center mb-4 shadow-md shadow-emerald-500/25">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">Penilaian Grade (A - D)</h3>
                <p class="text-sm text-gray-600 mb-4">Setiap setoran diverifikasi langsung oleh Admin:</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900">
                        <span class="font-bold block">Grade A (+4 Poin)</span>
                        <span class="text-[10px] text-emerald-700">Sangat Bagus</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-900">
                        <span class="font-bold block">Grade B (+3 Poin)</span>
                        <span class="text-[10px] text-blue-700">Bagus</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900">
                        <span class="font-bold block">Grade C (+2 Poin)</span>
                        <span class="text-[10px] text-amber-700">Cukup</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-red-50 border border-red-200 text-red-900">
                        <span class="font-bold block">Grade D (+1 Poin)</span>
                        <span class="text-[10px] text-red-700">Kurang Layak</span>
                    </div>
                </div>
            </div>

            <!-- 3. Konversi Rupiah Greedy -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs hover:shadow-xl hover:shadow-red-500/10 hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-rose-600 to-red-600 text-white flex items-center justify-center mb-4 shadow-md shadow-red-500/25">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-[#1F2937] mb-2">Konversi Greedy Rupiah</h3>
                <p class="text-sm text-gray-600 mb-4">Pecahan greedy dengan nilai konversi Rupiah tertinggi:</p>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-red-50/50 border border-red-100">
                        <span class="font-semibold text-gray-700">20 Poin</span>
                        <span class="font-bold text-red-600">Rp 1.000</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-red-50/50 border border-red-100">
                        <span class="font-semibold text-gray-700">10 Poin</span>
                        <span class="font-bold text-red-600">Rp 500</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-red-50/50 border border-red-100">
                        <span class="font-semibold text-gray-700">1 Poin</span>
                        <span class="font-bold text-red-600">Rp 100</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#E5E7EB] py-8 text-center text-xs text-gray-500 relative z-10">
        <p>&copy; {{ date('Y') }} <strong>EcoPoint Monolith</strong> &bull; Edisi Merah Modern (Red Theme).</p>
    </footer>

</body>
</html>
