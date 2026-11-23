@extends('layouts.guest', ['title' => 'Daftar Peserta'])

@section('content')
<div class="bg-white/95 backdrop-blur-md border border-[#E5E7EB] rounded-3xl p-6 sm:p-8 shadow-xl shadow-red-500/5">
    <div class="mb-6 text-center">
        <h1 class="font-heading font-extrabold text-2xl text-[#1F2937]">Daftar Akun Peserta</h1>
        <p class="text-sm text-gray-500 mt-1">Mulai setor limbah dan kumpulkan poin Rupiah</p>
    </div>

    @if($errors->any())
        <div class="mb-5 p-3.5 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden text-sm transition-all shadow-2xs"
                placeholder="Contoh: Budi Santoso">
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden text-sm transition-all shadow-2xs"
                placeholder="nama@email.com">
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Password</label>
            <input type="password" id="password" name="password" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden text-sm transition-all shadow-2xs"
                placeholder="Minimal 6 karakter">
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden text-sm transition-all shadow-2xs"
                placeholder="Ulangi password">
        </div>

        <button type="submit"
            class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white font-heading font-bold text-sm shadow-lg shadow-red-500/30 hover:opacity-95 hover:shadow-red-500/40 active:scale-[0.99] transition-all cursor-pointer">
            Buat Akun Peserta
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <p class="text-xs text-gray-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-red-600 hover:text-red-700 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
