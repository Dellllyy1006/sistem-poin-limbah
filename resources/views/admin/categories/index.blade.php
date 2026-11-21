@extends('layouts.app', ['title' => 'Kategori Limbah'])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#1F2937]">Kategori Limbah & Parameter Poin</h1>
            <p class="text-sm text-gray-500 mt-1">Konfigurasi parameter poin dasar dan pembagi satuan untuk kategori resmi.</p>
        </div>
    </div>

    <!-- Strict Domain Limitation Banner -->
    <div class="p-4 rounded-xl bg-orange-50 border border-orange-200 text-orange-900 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
        <svg class="w-5 h-5 text-[#F97316] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <strong class="font-bold">Batasan Domain Ketat (Strict Domain Rule):</strong>
            Sesuai dokumen aturan sistem (Rules.md), sistem <strong>HANYA</strong> menerima 2 kategori: <strong>Botol</strong> (satuan pcs) dan <strong>Kaleng</strong> (satuan gram). Penambahan jenis limbah di luar ketentuan ini dilarang oleh arsitektur sistem.
        </div>
    </div>

    <!-- Category Table -->
    <div class="bg-white border border-[#E5E7EB] rounded-2xl overflow-hidden shadow-xs">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-[#FAF9F6] text-xs font-semibold text-gray-500 uppercase border-b border-[#E5E7EB]">
                <tr>
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Nama Kategori</th>
                    <th class="py-4 px-6">Satuan Input</th>
                    <th class="py-4 px-6">Pembagi Satuan (Unit Divisor)</th>
                    <th class="py-4 px-6">Poin Dasar</th>
                    <th class="py-4 px-6">Formula Poin Dasar</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @foreach($categories as $category)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs font-bold text-gray-500">#{{ $category->id }}</td>
                        <td class="py-4 px-6 font-heading font-bold text-gray-900 text-base">
                            {{ $category->name }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $category->unit_type === 'pcs' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ $category->unit_type }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-semibold text-gray-800">
                            Per {{ number_format($category->unit_divisor) }} {{ $category->unit_type }}
                        </td>
                        <td class="py-4 px-6 font-bold text-[#F97316]">
                            {{ $category->base_point }} Poin
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-600 font-mono">
                            @if($category->name === 'Botol')
                                (Jumlah Botol / {{ $category->unit_divisor }}) &times; {{ $category->base_point }} Poin
                            @else
                                (Berat Gram / {{ $category->unit_divisor }}) &times; {{ $category->base_point }} Poin
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-xs transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Parameter
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
