@extends('layouts.app', ['title' => 'Detail Transaksi #' . $transaction->id])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-semibold text-[#F97316] hover:underline flex items-center gap-1 mb-2">
                &larr; Kembali ke Daftar Transaksi
            </a>
            <h1 class="font-heading font-extrabold text-2xl text-[#1F2937]">Transaksi Setoran #{{ $transaction->id }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Diajukan pada {{ $transaction->created_at->translatedFormat('d F Y, H:i:s') }}</p>
        </div>

        <div>
            @if($transaction->status === 'approved')
                <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-[#10B981] border border-emerald-300">
                    Disetujui
                </span>
            @elseif($transaction->status === 'pending')
                <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-[#F59E0B] border border-amber-300">
                    Menunggu Verifikasi
                </span>
            @else
                <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-[#EF4444] border border-red-300">
                    Ditolak
                </span>
            @endif
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Participant Info Card -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <h3 class="font-heading font-bold text-sm text-gray-500 uppercase tracking-wider mb-3">Informasi Peserta</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-semibold text-gray-800">{{ $transaction->user->name }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-gray-500">Email:</span>
                    <span class="font-semibold text-gray-800">{{ $transaction->user->email }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-gray-500">Saldo Poin Saat Ini:</span>
                    <span class="font-bold text-[#F97316]">{{ number_format($transaction->user->total_points) }} Poin</span>
                </div>
            </div>
        </div>

        <!-- Waste Info Card -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-5 shadow-xs">
            <h3 class="font-heading font-bold text-sm text-gray-500 uppercase tracking-wider mb-3">Detail Setoran Limbah</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-gray-500">Kategori Limbah:</span>
                    <span class="font-bold text-gray-800">{{ $transaction->category->name }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="text-gray-500">Kuantitas / Berat:</span>
                    <span class="font-bold text-[#1F2937] text-base">{{ number_format($transaction->quantity_or_weight) }} {{ $transaction->category->unit_type }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-gray-500">Aturan Poin Dasar:</span>
                    <span class="text-xs text-gray-600">Per {{ $transaction->category->unit_divisor }} {{ $transaction->category->unit_type }} = {{ $transaction->category->base_point }} Poin</span>
                </div>
            </div>
        </div>
    </div>

    @if($transaction->status === 'pending')
        <!-- Verification Action Card (Only if Pending) -->
        <div class="bg-white border-2 border-orange-200 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-3.5 h-3.5 rounded-full bg-[#F97316]"></span>
                <h2 class="font-heading font-bold text-xl text-[#1F2937]">Verifikasi & Penilaian Kelayakan</h2>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 mb-6">
                Tentukan grade kelayakan (A/B/C/D) fisik limbah yang disetor. Poin total dihitung otomatis oleh sistem dan saldo peserta baru akan bertambah saat transaksi disetujui.
            </p>

            <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" id="approveForm" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-3">
                        Pilih Grade Kelayakan (Wajib):
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach($grades as $grade)
                            @php
                                $preview = $gradePreviews[$grade->id] ?? null;
                            @endphp
                            <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all hover:border-[#F97316] has-checked:border-[#F97316] has-checked:bg-orange-50/40">
                                <input type="radio" name="grade_id" value="{{ $grade->id }}" required
                                    class="absolute top-4 right-4 text-[#F97316] focus:ring-[#F97316]">
                                <div class="flex items-center gap-2">
                                    <span class="font-heading font-extrabold text-xl
                                        @if($grade->grade_code === 'A') text-[#10B981]
                                        @elseif($grade->grade_code === 'B') text-[#3B82F6]
                                        @elseif($grade->grade_code === 'C') text-[#F59E0B]
                                        @else text-[#EF4444] @endif">
                                        Grade {{ $grade->grade_code }}
                                    </span>
                                </div>
                                <span class="text-xs font-medium text-gray-600 mt-1">{{ $grade->label }}</span>

                                <div class="mt-3 pt-2 border-t border-gray-100 text-xs">
                                    <div class="text-gray-500">Poin Grade: <strong class="text-gray-800">+{{ $grade->bonus_point }}</strong></div>
                                    @if($preview)
                                        <div class="text-[#F97316] font-bold mt-1 text-sm">
                                            Total: {{ $preview['total'] }} Poin
                                        </div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                        Catatan Verifikasi (Opsional)
                    </label>
                    <textarea id="notes" name="notes" rows="2"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-sm"
                        placeholder="Contoh: Kondisi botol bersih dan sudah dipress rapi."></textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                        class="px-5 py-2.5 rounded-xl border border-red-300 text-red-600 font-semibold text-xs hover:bg-red-50 transition-colors">
                        Tolak Transaksi
                    </button>

                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#10B981] to-emerald-600 text-white font-heading font-bold text-sm shadow-md shadow-emerald-500/20 hover:opacity-95 transition-all">
                        Setujui Transaksi & Tambah Poin
                    </button>
                </div>
            </form>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-xs">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl border border-gray-200">
                <h3 class="font-heading font-bold text-lg text-red-600">Tolak Transaksi #{{ $transaction->id }}</h3>
                <p class="text-xs text-gray-600">
                    Berikan alasan penolakan agar peserta memahami mengapa setoran tidak memenuhi syarat.
                </p>

                <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="reject_notes" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alasan Penolakan (Wajib)</label>
                        <textarea id="reject_notes" name="notes" rows="3" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 outline-hidden text-sm"
                            placeholder="Contoh: Kaleng berkarat parah dan bercampur dengan sampah organik basah."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 text-xs font-semibold hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-[#EF4444] text-white text-xs font-heading font-bold hover:bg-red-600">
                            Konfirmasi Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Verified Information Card -->
        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
            <h3 class="font-heading font-bold text-base text-[#1F2937] mb-4">Hasil Verifikasi Administrator</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-4">
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="block text-xs text-gray-500">Diverifikasi Oleh:</span>
                    <span class="font-semibold text-gray-800">{{ $transaction->verifier->name ?? 'Admin' }}</span>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="block text-xs text-gray-500">Grade yang Diberikan:</span>
                    <span class="font-bold text-gray-800">
                        {{ $transaction->grade ? 'Grade ' . $transaction->grade->grade_code . ' (' . $transaction->grade->label . ')' : '-' }}
                    </span>
                </div>
                <div class="p-4 rounded-xl bg-orange-50 border border-orange-200">
                    <span class="block text-xs text-orange-700">Total Poin yang Diberikan:</span>
                    <span class="font-heading font-extrabold text-xl text-[#F97316]">
                        {{ $transaction->status === 'approved' ? '+' . number_format($transaction->earned_points) . ' Poin' : '0 Poin' }}
                    </span>
                </div>
            </div>

            @if($transaction->notes)
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Catatan Verifikator:</span>
                    <p class="text-sm text-gray-700">{{ $transaction->notes }}</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
