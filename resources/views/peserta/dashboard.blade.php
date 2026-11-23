@extends('layouts.app', ['title' => 'Dashboard Peserta'])

@section('content')
<div class="space-y-8">
    <!-- Hero Balance Card (Obsidian & Crimson Edition) -->
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-950 via-slate-900 to-red-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-red-500/10 border border-red-900/40">
        <!-- Ambient Glowing Red Spots -->
        <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-gradient-to-tr from-red-600/30 to-rose-600/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -top-10 left-1/3 w-60 h-60 rounded-full bg-red-600/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-500/20 border border-red-500/30 text-rose-300 text-xs font-semibold backdrop-blur-md mb-3 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Saldo Tabungan Poin Limbah
                </span>
                <div class="flex items-baseline gap-3">
                    <h1 class="font-heading font-black text-4xl sm:text-5xl bg-gradient-to-r from-white via-rose-100 to-red-200 bg-clip-text text-transparent">
                        {{ number_format($totalPoints) }}
                    </h1>
                    <span class="text-xl font-heading font-semibold text-gray-300">Poin</span>
                </div>

                <!-- Greedy Rupiah Equivalent -->
                <div class="mt-4 flex flex-wrap items-center gap-2.5">
                    <span class="text-xs text-gray-400">Estimasi Nilai Tukar:</span>
                    <span class="font-heading font-extrabold text-xl text-red-400 bg-red-950/60 border border-red-800/60 px-3 py-1 rounded-xl">
                        Rp {{ number_format($rupiahEquivalent, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-gray-400 bg-white/5 border border-white/10 px-2.5 py-1 rounded-lg">
                        {{ $rupiahBreakdown['chunk_20_count'] }}x 20pt &bull; {{ $rupiahBreakdown['chunk_10_count'] }}x 10pt &bull; {{ $rupiahBreakdown['chunk_1_count'] }}x 1pt
                    </span>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="{{ route('peserta.transactions.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white font-heading font-bold text-sm shadow-lg shadow-red-500/35 hover:opacity-95 hover:shadow-red-500/50 active:scale-[0.98] transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4" />
                    </svg>
                    Setor Limbah Baru
                </a>
                <a href="{{ route('peserta.redemptions.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-heading font-semibold text-sm backdrop-blur-md border border-white/15 hover:border-white/30 transition-all duration-200">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Tukarkan ke Rupiah
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-red-200 transition-all duration-200">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Setoran Diajukan</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-gray-900">{{ $totalTransactions }}</span>
                <span class="text-xs text-gray-500">kali</span>
            </div>
            <div class="mt-2 text-xs text-gray-400">Total riwayat pengajuan</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-amber-200 transition-all duration-200">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Verifikasi</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#F59E0B]">{{ $pendingTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-2 text-xs text-amber-700 bg-amber-50 p-1.5 rounded-lg font-medium inline-block">Sedang dinilai Admin</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-emerald-200 transition-all duration-200">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Setoran Disetujui</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#10B981]">{{ $approvedTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-2 text-xs text-emerald-700 bg-emerald-50 p-1.5 rounded-lg font-medium inline-block">Poin telah masuk ke saldo</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-red-200 transition-all duration-200">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Rupiah Dicairkan</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-2xl text-red-600">Rp {{ number_format($totalClaimedRupiah, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2 text-xs text-red-700 bg-red-50 p-1.5 rounded-lg font-medium inline-block">Dana sukses diterima</div>
        </div>
    </div>

    <!-- 2 Column Section: Recent Submissions & Recent Redemptions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Submissions -->
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                    <h2 class="font-heading font-bold text-lg text-[#1F2937]">Setoran Limbah Terakhir</h2>
                </div>
                <a href="{{ route('peserta.transactions.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($recentTransactions->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada riwayat setoran limbah.</p>
                    <a href="{{ route('peserta.transactions.create') }}" class="mt-2 inline-block text-xs font-bold text-red-600 underline">
                        Mulai setor limbah pertama Anda!
                    </a>
                </div>
            @else
                <div class="divide-y divide-[#E5E7EB]">
                    @foreach($recentTransactions as $trx)
                        <div class="py-3 flex items-center justify-between hover:bg-gray-50/50 rounded-xl px-2 transition-colors">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-gray-800">{{ $trx->category->name }}</span>
                                    <span class="text-xs font-medium text-gray-500">({{ number_format($trx->quantity_or_weight) }} {{ $trx->category->unit_type }})</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                            <div class="text-right">
                                @if($trx->status === 'approved')
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-[#10B981] border border-emerald-200">
                                        +{{ $trx->earned_points }} Poin
                                    </span>
                                @elseif($trx->status === 'pending')
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-[#EF4444] border border-red-200">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Redemptions -->
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span>
                    <h2 class="font-heading font-bold text-lg text-[#1F2937]">Riwayat Penukaran Poin</h2>
                </div>
                <a href="{{ route('peserta.redemptions.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 hover:underline">
                    Kelola Penukaran &rarr;
                </a>
            </div>

            @if($recentRedemptions->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada penukaran poin ke Rupiah.</p>
                    <a href="{{ route('peserta.redemptions.index') }}" class="mt-2 inline-block text-xs font-bold text-red-600 underline">
                        Tukarkan saldo poin sekarang!
                    </a>
                </div>
            @else
                <div class="divide-y divide-[#E5E7EB]">
                    @foreach($recentRedemptions as $item)
                        <div class="py-3 flex items-center justify-between hover:bg-gray-50/50 rounded-xl px-2 transition-colors">
                            <div>
                                <div class="font-heading font-extrabold text-sm text-red-600">
                                    Rp {{ number_format($item->rupiah_amount, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ number_format($item->points_used) }} Poin &bull; {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                @if($item->status === 'completed')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981] border border-emerald-200">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">
                                        Diproses
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
