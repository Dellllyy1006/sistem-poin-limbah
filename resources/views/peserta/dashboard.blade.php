@extends('layouts.app', ['title' => 'Dashboard Peserta'])

@section('content')
<div class="space-y-8">
    <!-- Hero Balance Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#1F2937] via-gray-900 to-gray-800 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-gradient-to-tr from-[#F97316]/20 to-[#F59E0B]/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-orange-300 text-xs font-semibold backdrop-blur-xs mb-3">
                    <span class="w-2 h-2 rounded-full bg-[#F97316]"></span>
                    Saldo Tabungan Poin Limbah
                </span>
                <div class="flex items-baseline gap-3">
                    <h1 class="font-heading font-extrabold text-4xl sm:text-5xl bg-gradient-to-r from-white via-orange-50 to-amber-200 bg-clip-text text-transparent">
                        {{ number_format($totalPoints) }}
                    </h1>
                    <span class="text-xl font-heading font-semibold text-gray-300">Poin</span>
                </div>

                <!-- Greedy Rupiah Equivalent -->
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <span class="text-xs text-gray-400">Estimasi Nilai Tukar:</span>
                    <span class="font-heading font-bold text-lg text-[#F59E0B]">
                        Rp {{ number_format($rupiahEquivalent, 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-gray-400">
                        ({{ $rupiahBreakdown['chunk_20_count'] }}x 20pt, {{ $rupiahBreakdown['chunk_10_count'] }}x 10pt, {{ $rupiahBreakdown['chunk_1_count'] }}x 1pt)
                    </span>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="{{ route('peserta.transactions.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white font-heading font-bold text-sm shadow-md shadow-orange-500/30 hover:opacity-95 active:scale-[0.99] transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Setor Limbah Baru
                </a>
                <a href="{{ route('peserta.redemptions.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-heading font-semibold text-sm backdrop-blur-xs border border-white/10 transition-all">
                    <svg class="w-5 h-5 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Tukarkan ke Rupiah
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Setoran Diajukan</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-gray-800">{{ $totalTransactions }}</span>
                <span class="text-xs text-gray-500">kali</span>
            </div>
            <div class="mt-2 text-xs text-gray-400">Total riwayat pengajuan</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Verifikasi</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#F59E0B]">{{ $pendingTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-2 text-xs text-amber-600 font-medium">Sedang dinilai Admin</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Setoran Disetujui</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#10B981]">{{ $approvedTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-2 text-xs text-emerald-600 font-medium">Poin telah masuk ke saldo</div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Rupiah Dicairkan</span>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-2xl text-gray-800">Rp {{ number_format($totalClaimedRupiah, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2 text-xs text-blue-600 font-medium">Dana sukses diterima</div>
        </div>
    </div>

    <!-- 2 Column Section: Recent Submissions & Recent Redemptions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Submissions -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-heading font-bold text-lg text-[#1F2937]">Setoran Limbah Terakhir</h2>
                <a href="{{ route('peserta.transactions.index') }}" class="text-xs font-semibold text-[#F97316] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($recentTransactions->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada riwayat setoran limbah.</p>
                    <a href="{{ route('peserta.transactions.create') }}" class="mt-2 inline-block text-xs font-semibold text-[#F97316] underline">
                        Mulai setor limbah pertama Anda!
                    </a>
                </div>
            @else
                <div class="divide-y divide-[#E5E7EB]">
                    @foreach($recentTransactions as $trx)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-sm text-gray-800">{{ $trx->category->name }}</span>
                                    <span class="text-xs font-medium text-gray-500">({{ number_format($trx->quantity_or_weight) }} {{ $trx->category->unit_type }})</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                            <div class="text-right">
                                @if($trx->status === 'approved')
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-[#10B981]">
                                        +{{ $trx->earned_points }} Poin
                                    </span>
                                @elseif($trx->status === 'pending')
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-amber-100 text-[#F59E0B]">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-[#EF4444]">
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
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-heading font-bold text-lg text-[#1F2937]">Riwayat Penukaran Poin</h2>
                <a href="{{ route('peserta.redemptions.index') }}" class="text-xs font-semibold text-[#F97316] hover:underline">
                    Kelola Penukaran &rarr;
                </a>
            </div>

            @if($recentRedemptions->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada penukaran poin ke Rupiah.</p>
                    <a href="{{ route('peserta.redemptions.index') }}" class="mt-2 inline-block text-xs font-semibold text-[#F97316] underline">
                        Tukarkan saldo poin sekarang!
                    </a>
                </div>
            @else
                <div class="divide-y divide-[#E5E7EB]">
                    @foreach($recentRedemptions as $item)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <div class="font-heading font-bold text-sm text-gray-800">
                                    Rp {{ number_format($item->rupiah_amount, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ number_format($item->points_used) }} Poin &bull; {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                @if($item->status === 'completed')
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981]">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B]">
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
