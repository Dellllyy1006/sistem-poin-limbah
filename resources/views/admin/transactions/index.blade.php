@extends('layouts.app', ['title' => 'Verifikasi Transaksi Limbah'])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Kelola & Verifikasi Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Periksa setoran limbah peserta, berikan grade kelayakan (A/B/C/D), dan setujui penambahan poin.</p>
        </div>
    </div>

    <!-- Filter Tabs (Red Accent) -->
    <div class="flex flex-wrap items-center gap-2 border-b border-[#E5E7EB] pb-3">
        <a href="{{ route('admin.transactions.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ empty($status) ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'bg-white border border-[#E5E7EB] text-gray-600 hover:bg-gray-50' }}">
            Semua Transaksi
        </a>
        <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'pending' ? 'bg-[#F59E0B] text-white shadow-xs' : 'bg-white border border-[#E5E7EB] text-amber-700 hover:bg-amber-50/50' }}">
            Pending Verifikasi
        </a>
        <a href="{{ route('admin.transactions.index', ['status' => 'approved']) }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'approved' ? 'bg-[#10B981] text-white shadow-xs' : 'bg-white border border-[#E5E7EB] text-emerald-700 hover:bg-emerald-50/50' }}">
            Disetujui
        </a>
        <a href="{{ route('admin.transactions.index', ['status' => 'rejected']) }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'rejected' ? 'bg-[#EF4444] text-white shadow-xs' : 'bg-white border border-[#E5E7EB] text-red-700 hover:bg-red-50/50' }}">
            Ditolak
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xs">
        @if($transactions->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-sm font-medium">Tidak ada transaksi yang cocok dengan filter ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-b border-[#E5E7EB]">
                        <tr>
                            <th class="py-3.5 px-4">ID</th>
                            <th class="py-3.5 px-4">Peserta</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Jumlah/Berat</th>
                            <th class="py-3.5 px-4">Grade</th>
                            <th class="py-3.5 px-4">Poin</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Pengajuan</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($transactions as $trx)
                            <tr class="hover:bg-red-50/20 transition-colors">
                                <td class="py-3.5 px-4 font-mono text-xs font-bold text-gray-500">#{{ $trx->id }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-gray-900">{{ $trx->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $trx->user->email }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $trx->category->name === 'Botol' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
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
                                        <span class="text-xs text-amber-600 font-semibold italic">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-sm {{ $trx->earned_points > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    @if($trx->status === 'approved')
                                        +{{ number_format($trx->earned_points) }}
                                    @else
                                        -
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
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('admin.transactions.show', $trx) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl {{ $trx->status === 'pending' ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-xs shadow-red-500/25' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} text-xs font-bold transition-all">
                                        {{ $trx->status === 'pending' ? 'Verifikasi' : 'Detail' }}
                                    </a>
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
