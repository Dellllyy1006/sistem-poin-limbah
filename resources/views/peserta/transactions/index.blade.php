@extends('layouts.app', ['title' => 'Riwayat Setoran Limbah'])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Riwayat Setoran Limbah</h1>
            <p class="text-sm text-gray-500 mt-1">Lacak status verifikasi, grade kelayakan, dan poin yang diperoleh dari setiap setoran.</p>
        </div>
        <a href="{{ route('peserta.transactions.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white text-xs font-heading font-bold shadow-md shadow-orange-500/20 hover:opacity-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Setor Limbah Baru
        </a>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white border border-[#E5E7EB] rounded-2xl overflow-hidden shadow-xs">
        @if($transactions->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="text-base font-semibold text-gray-600">Belum ada transaksi setoran limbah</p>
                <p class="text-xs text-gray-400 mt-1">Mulai kumpulkan botol atau kaleng dan setor ke sistem.</p>
                <a href="{{ route('peserta.transactions.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#F97316] text-white text-xs font-bold hover:bg-orange-600 transition-colors">
                    Setor Limbah Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-b border-[#E5E7EB]">
                        <tr>
                            <th class="py-3.5 px-4">ID Transaksi</th>
                            <th class="py-3.5 px-4">Kategori Limbah</th>
                            <th class="py-3.5 px-4">Jumlah / Berat</th>
                            <th class="py-3.5 px-4">Grade Penilaian</th>
                            <th class="py-3.5 px-4">Poin Diperoleh</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Setor</th>
                            <th class="py-3.5 px-4">Catatan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($transactions as $trx)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-mono text-xs font-bold text-gray-500">#{{ $trx->id }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $trx->category->name === 'Botol' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-orange-50 text-orange-700 border border-orange-200' }}">
                                        {{ $trx->category->name }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-800">
                                    {{ number_format($trx->quantity_or_weight) }} {{ $trx->category->unit_type }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($trx->grade)
                                        <span class="inline-block px-2.5 py-0.5 rounded text-xs font-bold
                                            @if($trx->grade->grade_code === 'A') bg-emerald-100 text-[#10B981] border border-emerald-300
                                            @elseif($trx->grade->grade_code === 'B') bg-blue-100 text-[#3B82F6] border border-blue-300
                                            @elseif($trx->grade->grade_code === 'C') bg-amber-100 text-[#F59E0B] border border-amber-300
                                            @else bg-red-100 text-[#EF4444] border border-red-300 @endif">
                                            Grade {{ $trx->grade->grade_code }} (+{{ $trx->grade->bonus_point }} Poin)
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Menunggu Evaluasi</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-heading font-extrabold text-sm {{ $trx->earned_points > 0 ? 'text-[#F97316]' : 'text-gray-400' }}">
                                    @if($trx->status === 'approved')
                                        +{{ number_format($trx->earned_points) }} Poin
                                    @else
                                        0 Poin
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($trx->status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981] border border-emerald-200">Disetujui</span>
                                    @elseif($trx->status === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">Pending</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-[#EF4444] border border-red-200">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    {{ $trx->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-600 max-w-xs truncate" title="{{ $trx->notes }}">
                                    {{ $trx->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#E5E7EB]">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
