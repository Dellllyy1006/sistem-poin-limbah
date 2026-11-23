@extends('layouts.app', ['title' => 'Pengelolaan Penukaran Poin'])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Klaim Penukaran Poin ke Rupiah</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar permintaan pencairan poin peserta menjadi uang tunai Rupiah.</p>
        </div>
    </div>

    <!-- Filter Tabs (Red Theme) -->
    <div class="flex flex-wrap items-center gap-2 border-b border-[#E5E7EB] pb-3">
        <a href="{{ route('admin.redemptions.index') }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ empty($status) ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-500/25' : 'bg-white border border-[#E5E7EB] text-gray-600 hover:bg-gray-50' }}">
            Semua Penukaran
        </a>
        <a href="{{ route('admin.redemptions.index', ['status' => 'pending']) }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'pending' ? 'bg-[#F59E0B] text-white shadow-xs' : 'bg-white border border-[#E5E7EB] text-amber-700 hover:bg-amber-50/50' }}">
            Menunggu Diproses (Pending)
        </a>
        <a href="{{ route('admin.redemptions.index', ['status' => 'completed']) }}"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'completed' ? 'bg-[#10B981] text-white shadow-xs' : 'bg-white border border-[#E5E7EB] text-emerald-700 hover:bg-emerald-50/50' }}">
            Selesai Ditransfer (Completed)
        </a>
    </div>

    <!-- Redemptions Table -->
    <div class="bg-white border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xs">
        @if($redemptions->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">Belum ada data penukaran poin.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-b border-[#E5E7EB]">
                        <tr>
                            <th class="py-3.5 px-4">ID Klaim</th>
                            <th class="py-3.5 px-4">Peserta</th>
                            <th class="py-3.5 px-4">Poin Ditukarkan</th>
                            <th class="py-3.5 px-4">Nilai Rupiah</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Pengajuan</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($redemptions as $item)
                            <tr class="hover:bg-red-50/20 transition-colors">
                                <td class="py-3.5 px-4 font-mono text-xs font-bold text-gray-500">#{{ $item->id }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-gray-900">{{ $item->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->user->email }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-red-600">
                                    {{ number_format($item->points_used) }} Poin
                                </td>
                                <td class="py-3.5 px-4 font-heading font-black text-gray-900 text-base">
                                    Rp {{ number_format($item->rupiah_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($item->status === 'completed')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981] border border-emerald-200">
                                            Selesai Ditransfer
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">
                                            Pending Pencairan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if($item->status === 'pending')
                                        <form action="{{ route('admin.redemptions.complete', $item) }}" method="POST" class="inline" onsubmit="return confirm('Tandai penukaran ini sebagai selesai ditransfer ke peserta?')">
                                            @csrf
                                            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-heading font-bold text-xs shadow-xs hover:opacity-95 transition-all cursor-pointer">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">Sudah Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#E5E7EB]">
                {{ $redemptions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
