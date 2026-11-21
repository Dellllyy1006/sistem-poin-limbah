@extends('layouts.app', ['title' => 'Edit Parameter Kategori'])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-[#F97316] hover:underline flex items-center gap-1 mb-2">
            &larr; Kembali ke Daftar Kategori
        </a>
        <h1 class="font-heading font-extrabold text-2xl text-[#1F2937]">Edit Parameter: {{ $category->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Ubah pembagi satuan dan perolehan poin dasar.</p>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Kategori</label>
                <input type="text" value="{{ $category->name }}" disabled
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 text-sm font-semibold cursor-not-allowed">
                <p class="text-[11px] text-gray-400 mt-1">Nama kategori dikunci sesuai aturan domain sistem (Botol & Kaleng).</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Satuan Input</label>
                <input type="text" value="{{ $category->unit_type }}" disabled
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 text-sm font-semibold cursor-not-allowed">
            </div>

            <div>
                <label for="unit_divisor" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                    Nilai Pembagi Satuan (Unit Divisor)
                </label>
                <div class="relative">
                    <input type="number" id="unit_divisor" name="unit_divisor" value="{{ old('unit_divisor', $category->unit_divisor) }}" min="1" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-sm">
                    <span class="absolute right-4 top-2.5 text-xs text-gray-400 font-semibold">{{ $category->unit_type }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Misal: 100 gram untuk Kaleng, 1 pcs untuk Botol.
                </p>
            </div>

            <div>
                <label for="base_point" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">
                    Poin Dasar per Satuan
                </label>
                <div class="relative">
                    <input type="number" id="base_point" name="base_point" value="{{ old('base_point', $category->base_point) }}" min="1" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-sm">
                    <span class="absolute right-4 top-2.5 text-xs text-gray-400 font-semibold">Poin</span>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white font-heading font-bold text-sm shadow-md shadow-orange-500/20 hover:opacity-95 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
