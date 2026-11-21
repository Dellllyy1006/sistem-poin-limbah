@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<div class="space-y-8">
    <!-- Header Greeting -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Dashboard Administrator</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau setoran limbah, verifikasi transaksi, dan kelola penukaran poin peserta.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white text-xs font-heading font-bold shadow-md shadow-orange-500/20 hover:opacity-95 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi Setoran ({{ $pendingTransactions }})
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Menunggu Verifikasi -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Antrean Verifikasi</span>
                <span class="w-9 h-9 rounded-xl bg-amber-100 text-[#F59E0B] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#F59E0B]">{{ $pendingTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-3 text-xs text-amber-700 bg-amber-50 p-2 rounded-lg font-medium">
                Memerlukan evaluasi grade
            </div>
        </div>

        <!-- 2. Transaksi Disetujui -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Disetujui</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-100 text-[#10B981] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#10B981]">{{ $approvedTransactions }}</span>
                <span class="text-xs text-gray-500">transaksi</span>
            </div>
            <div class="mt-3 text-xs text-emerald-700 bg-emerald-50 p-2 rounded-lg font-medium">
                Poin berhasil ditambahkan
            </div>
        </div>

        <!-- 3. Total Poin Diberikan -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Poin Beredar</span>
                <span class="w-9 h-9 rounded-xl bg-orange-100 text-[#F97316] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-3xl text-[#F97316]">{{ number_format($totalPointsDistributed) }}</span>
                <span class="text-xs text-gray-500">Poin</span>
            </div>
            <div class="mt-3 text-xs text-orange-700 bg-orange-50 p-2 rounded-lg font-medium">
                Akumulasi seluruh peserta
            </div>
        </div>

        <!-- 4. Total Pencairan Rupiah -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Dicairkan</span>
                <span class="w-9 h-9 rounded-xl bg-blue-100 text-[#3B82F6] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-heading font-extrabold text-2xl text-gray-800">Rp {{ number_format($totalRedeemedRupiah, 0, ',', '.') }}</span>
            </div>
            <div class="mt-3 text-xs text-blue-700 bg-blue-50 p-2 rounded-lg font-medium">
                {{ $pendingRedemptions }} klaim pending
            </div>
        </div>
    </div>

    <!-- Antrean Pending Verifikasi -->
    <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#F59E0B]"></span>
                <h2 class="font-heading font-bold text-lg text-[#1F2937]">Antrean Verifikasi Transaksi Limbah Terbaru</h2>
            </div>
            <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="text-xs font-semibold text-[#F97316] hover:underline">
                Lihat Semua Antrean &rarr;
            </a>
        </div>

        @if($recentPending->isEmpty())
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">Tidak ada transaksi yang menunggu verifikasi.</p>
                <p class="text-xs text-gray-400">Semua setoran limbah telah selesai diproses.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-y border-[#E5E7EB]">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Peserta</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Kuantitas</th>
                            <th class="py-3 px-4">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($recentPending as $trx)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3 px-4 font-mono text-xs font-bold text-gray-500">#{{ $trx->id }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-gray-800">{{ $trx->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $trx->user->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $trx->category->name === 'Botol' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-orange-50 text-orange-700 border border-orange-200' }}">
                                        {{ $trx->category->name }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-semibold text-gray-800">
                                    {{ number_format($trx->quantity_or_weight) }} {{ $trx->category->unit_type }}
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-500">
                                    {{ $trx->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.transactions.show', $trx) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white text-xs font-heading font-semibold hover:opacity-95 shadow-xs">
                                        Verifikasi & Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Riwayat Transaksi Terbaru -->
    <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-heading font-bold text-lg text-[#1F2937]">Semua Aktivitas Transaksi Terbaru</h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-semibold text-[#F97316] hover:underline">
                Kelola Semua Transaksi &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-700">
                <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-y border-[#E5E7EB]">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Peserta</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Jumlah/Berat</th>
                        <th class="py-3 px-4">Grade</th>
                        <th class="py-3 px-4">Poin</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @foreach($recentTransactions as $trx)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="py-3 px-4 font-mono text-xs font-bold text-gray-500">#{{ $trx->id }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $trx->user->name }}</td>
                            <td class="py-3 px-4">{{ $trx->category->name }}</td>
                            <td class="py-3 px-4 font-semibold">{{ number_format($trx->quantity_or_weight) }} {{ $trx->category->unit_type }}</td>
                            <td class="py-3 px-4">
                                @if($trx->grade)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-bold
                                        @if($trx->grade->grade_code === 'A') bg-emerald-100 text-[#10B981] border border-emerald-300
                                        @elseif($trx->grade->grade_code === 'B') bg-blue-100 text-[#3B82F6] border border-blue-300
                                        @elseif($trx->grade->grade_code === 'C') bg-amber-100 text-[#F59E0B] border border-amber-300
                                        @else bg-red-100 text-[#EF4444] border border-red-300 @endif">
                                        Grade {{ $trx->grade->grade_code }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-bold {{ $trx->earned_points > 0 ? 'text-[#F97316]' : 'text-gray-400' }}">
                                +{{ number_format($trx->earned_points) }}
                            </td>
                            <td class="py-3 px-4">
                                @if($trx->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981] border border-emerald-200">Disetujui</span>
                                @elseif($trx->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-[#EF4444] border border-red-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.transactions.show', $trx) }}" class="text-xs font-semibold text-gray-600 hover:text-[#F97316]">
                                    Lihat &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
