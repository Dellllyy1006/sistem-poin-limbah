@extends('layouts.app', ['title' => 'Tukar Poin ke Rupiah'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Tukarkan Poin ke Rupiah</h1>
            <p class="text-sm text-gray-500 mt-1">Konversikan poin limbah Anda dengan pecahan greedy nilai tertinggi.</p>
        </div>
    </div>

    <!-- 2 Column Layout: Redemption Form & Calculator alongside History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Klaim Penukaran -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Saldo Card -->
            <div class="bg-gradient-to-br from-[#1F2937] to-gray-800 rounded-2xl p-6 text-white shadow-md">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Saldo Poin Tersedia</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span id="currentPoints" class="font-heading font-extrabold text-4xl text-[#F59E0B]">
                        {{ number_format($totalPoints) }}
                    </span>
                    <span class="text-sm font-semibold text-gray-300">Poin</span>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-700/60 text-xs text-gray-300 flex justify-between">
                    <span>Maksimum Nilai Tukar:</span>
                    <strong class="text-amber-300">Rp {{ number_format($maxRupiah, 0, ',', '.') }}</strong>
                </div>
            </div>

            <!-- Redemption Input Form -->
            <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
                <h3 class="font-heading font-bold text-base text-[#1F2937] mb-4">Formulir Pencairan Poin</h3>

                @if($totalPoints < 1)
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs text-center">
                        <p class="font-semibold">Saldo poin Anda saat ini belum mencukupi.</p>
                        <p class="mt-1 text-gray-600">Kumpulkan dan setor sampah botol / kaleng untuk mendapatkan poin.</p>
                    </div>
                @else
                    <form action="{{ route('peserta.redemptions.store') }}" method="POST" id="redeemForm" class="space-y-5">
                        @csrf

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="points_used" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Jumlah Poin Ditukar
                                </label>
                                <button type="button" onclick="setAllPoints()" class="text-xs font-bold text-[#F97316] hover:underline cursor-pointer">
                                    Tukar Semua ({{ $totalPoints }} Poin)
                                </button>
                            </div>
                            <div class="relative">
                                <input type="number" id="points_used" name="points_used" value="{{ old('points_used', min(20, $totalPoints)) }}"
                                    min="1" max="{{ $totalPoints }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-base font-bold text-gray-900">
                                <span class="absolute right-4 top-3.5 text-xs text-gray-400 font-bold uppercase">Poin</span>
                            </div>
                            @error('points_used')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Live Greedy Calculation Breakdown Box -->
                        <div class="p-4 rounded-xl bg-[#FAF9F6] border border-gray-200 space-y-2 text-xs">
                            <span class="font-bold text-gray-700 block uppercase tracking-wider text-[11px]">Rincian Perhitungan Pecahan Greedy:</span>

                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-gray-600">Pecahan 20 Poin (<span class="font-semibold text-gray-800">Rp 1.000</span>):</span>
                                <span id="chunk20Text" class="font-bold text-gray-800">1x = Rp 1.000</span>
                            </div>

                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-gray-600">Pecahan 10 Poin (<span class="font-semibold text-gray-800">Rp 500</span>):</span>
                                <span id="chunk10Text" class="font-bold text-gray-800">0x = Rp 0</span>
                            </div>

                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-gray-600">Pecahan 1 Poin (<span class="font-semibold text-gray-800">Rp 100</span>):</span>
                                <span id="chunk1Text" class="font-bold text-gray-800">0x = Rp 0</span>
                            </div>

                            <div class="flex justify-between pt-2 text-sm">
                                <span class="font-heading font-bold text-gray-900">Total Diterima:</span>
                                <span id="totalRupiahText" class="font-heading font-extrabold text-base text-[#F97316]">
                                    Rp 1.000
                                </span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white font-heading font-bold text-sm shadow-md shadow-orange-500/25 hover:opacity-95 active:scale-[0.99] transition-all cursor-pointer">
                            Ajukan Penukaran Sekarang
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Redemption History Table -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-[#E5E7EB] rounded-2xl overflow-hidden shadow-xs">
                <div class="p-5 border-b border-[#E5E7EB] flex items-center justify-between">
                    <h2 class="font-heading font-bold text-base text-[#1F2937]">Riwayat Penukaran Poin</h2>
                    <span class="text-xs text-gray-400 font-medium">{{ $redemptions->total() }} klaim tercatat</span>
                </div>

                @if($redemptions->isEmpty())
                    <div class="text-center py-16 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium">Belum ada riwayat penukaran poin.</p>
                        <p class="text-xs text-gray-400 mt-1">Gunakan form di samping untuk mulai mencairkan poin Anda.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-700">
                            <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-b border-[#E5E7EB]">
                                <tr>
                                    <th class="py-3 px-4">ID Klaim</th>
                                    <th class="py-3 px-4">Poin Ditukar</th>
                                    <th class="py-3 px-4">Nilai Rupiah</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Tanggal Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E5E7EB]">
                                @foreach($redemptions as $item)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-mono text-xs font-bold text-gray-500">#{{ $item->id }}</td>
                                        <td class="py-3.5 px-4 font-bold text-[#F97316]">
                                            {{ number_format($item->points_used) }} Poin
                                        </td>
                                        <td class="py-3.5 px-4 font-heading font-extrabold text-gray-900 text-sm">
                                            Rp {{ number_format($item->rupiah_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @if($item->status === 'completed')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-[#10B981] border border-emerald-200">
                                                    Selesai Ditransfer
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-[#F59E0B] border border-amber-200">
                                                    Pending Admin
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-gray-500">
                                            {{ $item->created_at->translatedFormat('d M Y, H:i') }}
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
    </div>
</div>

@push('scripts')
<script>
    const userMaxPoints = {{ $totalPoints }};

    function setAllPoints() {
        const input = document.getElementById('points_used');
        if (input) {
            input.value = userMaxPoints;
            calculateGreedy();
        }
    }

    function calculateGreedy() {
        const input = document.getElementById('points_used');
        if (!input) return;

        let points = parseInt(input.value) || 0;
        if (points < 0) points = 0;

        let rem = points;
        const c20 = Math.floor(rem / 20);
        const r20 = c20 * 1000;
        rem %= 20;

        const c10 = Math.floor(rem / 10);
        const r10 = c10 * 500;
        rem %= 10;

        const c1 = rem;
        const r1 = c1 * 100;

        const total = r20 + r10 + r1;

        document.getElementById('chunk20Text').textContent = c20 + 'x = Rp ' + r20.toLocaleString('id-ID');
        document.getElementById('chunk10Text').textContent = c10 + 'x = Rp ' + r10.toLocaleString('id-ID');
        document.getElementById('chunk1Text').textContent = c1 + 'x = Rp ' + r1.toLocaleString('id-ID');
        document.getElementById('totalRupiahText').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('points_used');
        if (input) {
            input.addEventListener('input', calculateGreedy);
            calculateGreedy();
        }
    });
</script>
@endpush
@endsection
