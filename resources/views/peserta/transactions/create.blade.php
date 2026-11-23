@extends('layouts.app', ['title' => 'Form Setor Limbah'])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('peserta.transactions.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 hover:underline flex items-center gap-1 mb-2">
            &larr; Kembali ke Riwayat Transaksi
        </a>
        <h1 class="font-heading font-extrabold text-2xl text-[#1F2937]">Form Pengajuan Setor Limbah</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih kategori limbah resmi (Botol atau Kaleng) dan masukkan kuantitasnya.</p>
    </div>

    <!-- Info Rules Banner -->
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-950 text-xs sm:text-sm shadow-xs flex items-start gap-3">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <strong class="font-bold text-red-900">Ketentuan Setoran Limbah:</strong>
            <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-red-900">
                <li><strong>Botol:</strong> Wajib diinput dalam satuan <strong>pcs (buah)</strong>. 1 Botol = 1 Poin Dasar.</li>
                <li><strong>Kaleng:</strong> Wajib diinput dalam satuan <strong>gram (berat)</strong>. Setiap 100 gram = 1 Poin Dasar.</li>
                <li>Poin final akan ditambah bonus Grade kelayakan (Grade A: +4, B: +3, C: +2, D: +1) setelah diverifikasi oleh Admin.</li>
            </ul>
        </div>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-3xl p-6 sm:p-8 shadow-xs">
        <form action="{{ route('peserta.transactions.store') }}" method="POST" id="transactionForm" class="space-y-6">
            @csrf

            <!-- Category Selector -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5">
                    Pilih Jenis Limbah (Wajib)
                </label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($categories as $category)
                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:border-red-500 has-checked:border-red-600 has-checked:bg-red-50/50 has-checked:ring-2 has-checked:ring-red-400/20">
                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                                data-unit="{{ $category->unit_type }}"
                                data-divisor="{{ $category->unit_divisor }}"
                                data-base="{{ $category->base_point }}"
                                {{ (old('category_id') == $category->id || $loop->first) ? 'checked' : '' }}
                                class="absolute top-4 right-4 text-red-600 focus:ring-red-500">
                            <div class="font-heading font-extrabold text-base text-gray-900">
                                {{ $category->name }}
                            </div>
                            <span class="text-xs text-gray-500 mt-0.5">
                                Satuan: <strong class="text-gray-700">{{ $category->unit_type }}</strong>
                            </span>
                            <div class="mt-3 text-[11px] font-bold text-red-600">
                                @if($category->name === 'Botol')
                                    1 Botol = 1 Poin Dasar
                                @else
                                    100 Gram = 1 Poin Dasar
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('category_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity / Weight Input -->
            <div>
                <label for="quantity_or_weight" id="quantityLabel" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Jumlah Botol (pcs)
                </label>
                <div class="relative">
                    <input type="number" id="quantity_or_weight" name="quantity_or_weight" value="{{ old('quantity_or_weight', 1) }}" min="1" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden text-base font-bold text-gray-900 shadow-2xs">
                    <span id="unitBadge" class="absolute right-4 top-3.5 text-xs text-gray-400 font-bold uppercase">
                        pcs
                    </span>
                </div>
                <p id="helperText" class="text-xs text-gray-500 mt-1">
                    Masukkan jumlah fisik botol yang akan disetor.
                </p>
                @error('quantity_or_weight')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dynamic Live Calculation Preview -->
            <div class="p-5 rounded-2xl bg-gradient-to-r from-red-50/80 via-rose-50/50 to-white border border-red-200">
                <span class="text-xs font-bold text-red-800 uppercase tracking-wider block mb-2">Simulasi Perolehan Poin:</span>
                <div class="flex items-baseline justify-between mb-3">
                    <span class="text-sm text-gray-600">Estimasi Poin Dasar:</span>
                    <span id="basePointPreview" class="font-heading font-extrabold text-xl text-red-600">1 Poin</span>
                </div>

                <div class="pt-3 border-t border-red-200/80">
                    <span class="text-xs text-gray-500 block mb-2">Total perkiraan poin sesuai grade kelayakan dari Admin:</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-xs">
                        <div class="p-2.5 rounded-xl bg-white border border-emerald-200 shadow-2xs">
                            <span class="text-emerald-700 font-bold block">Grade A (+4)</span>
                            <span id="gradeAPreview" class="font-extrabold text-gray-800 text-sm">5 Poin</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white border border-blue-200 shadow-2xs">
                            <span class="text-blue-700 font-bold block">Grade B (+3)</span>
                            <span id="gradeBPreview" class="font-extrabold text-gray-800 text-sm">4 Poin</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white border border-amber-200 shadow-2xs">
                            <span class="text-amber-700 font-bold block">Grade C (+2)</span>
                            <span id="gradeCPreview" class="font-extrabold text-gray-800 text-sm">3 Poin</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white border border-red-200 shadow-2xs">
                            <span class="text-red-700 font-bold block">Grade D (+1)</span>
                            <span id="gradeDPreview" class="font-extrabold text-gray-800 text-sm">2 Poin</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('peserta.transactions.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white font-heading font-bold text-sm shadow-md shadow-red-500/30 hover:opacity-95 hover:shadow-red-500/40 active:scale-[0.98] transition-all cursor-pointer">
                    Ajukan Setoran Limbah
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryRadios = document.querySelectorAll('input[name="category_id"]');
        const quantityInput = document.getElementById('quantity_or_weight');
        const quantityLabel = document.getElementById('quantityLabel');
        const unitBadge = document.getElementById('unitBadge');
        const helperText = document.getElementById('helperText');

        const basePreview = document.getElementById('basePointPreview');
        const gradeAPreview = document.getElementById('gradeAPreview');
        const gradeBPreview = document.getElementById('gradeBPreview');
        const gradeCPreview = document.getElementById('gradeCPreview');
        const gradeDPreview = document.getElementById('gradeDPreview');

        function updateFormUI() {
            const checked = document.querySelector('input[name="category_id"]:checked');
            if (!checked) return;

            const name = checked.getAttribute('data-name');
            const unit = checked.getAttribute('data-unit');
            const divisor = parseInt(checked.getAttribute('data-divisor')) || 1;
            const basePointVal = parseInt(checked.getAttribute('data-base')) || 1;

            if (name === 'Botol') {
                quantityLabel.textContent = 'Jumlah Botol (pcs)';
                unitBadge.textContent = 'pcs';
                helperText.textContent = 'Masukkan jumlah fisik botol yang akan disetor (1 pcs = 1 Poin Dasar).';
                if (parseInt(quantityInput.value) > 500 && quantityInput.value === '500') {
                    quantityInput.value = 10;
                }
            } else {
                quantityLabel.textContent = 'Berat Kaleng (gram)';
                unitBadge.textContent = 'gram';
                helperText.textContent = 'Masukkan berat kaleng dalam gram. Setiap 100 gram = 1 Poin Dasar.';
                if (parseInt(quantityInput.value) <= 1) {
                    quantityInput.value = 100;
                }
            }

            calculateSimulation();
        }

        function calculateSimulation() {
            const checked = document.querySelector('input[name="category_id"]:checked');
            if (!checked) return;

            const divisor = parseInt(checked.getAttribute('data-divisor')) || 1;
            const basePointVal = parseInt(checked.getAttribute('data-base')) || 1;
            const qty = parseInt(quantityInput.value) || 0;

            const units = Math.floor(qty / divisor);
            const basePoints = units * basePointVal;

            basePreview.textContent = basePoints + ' Poin';
            gradeAPreview.textContent = (basePoints + 4) + ' Poin';
            gradeBPreview.textContent = (basePoints + 3) + ' Poin';
            gradeCPreview.textContent = (basePoints + 2) + ' Poin';
            gradeDPreview.textContent = (basePoints + 1) + ' Poin';
        }

        categoryRadios.forEach(r => r.addEventListener('change', updateFormUI));
        quantityInput.addEventListener('input', calculateSimulation);

        updateFormUI();
    });
</script>
@endpush
@endsection
