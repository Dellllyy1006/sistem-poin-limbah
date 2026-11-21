@extends('layouts.guest', ['title' => 'Masuk'])

@section('content')
<div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 sm:p-8 shadow-sm">
    <div class="mb-6 text-center">
        <h1 class="font-heading font-bold text-2xl text-[#1F2937]">Masuk ke Akun</h1>
        <p class="text-sm text-gray-500 mt-1">Gunakan akun Anda untuk mengakses sistem EcoPoint</p>
    </div>

    @if($errors->any())
        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-sm transition-all"
                placeholder="nama@email.com">
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
            </div>
            <input type="password" id="password" name="password" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#F97316] focus:border-transparent outline-hidden text-sm transition-all"
                placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between text-xs text-gray-600">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded-md border-gray-300 text-[#F97316] focus:ring-[#F97316]">
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <button type="submit"
            class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-[#F97316] to-[#F59E0B] text-white font-heading font-semibold text-sm shadow-md shadow-orange-500/25 hover:opacity-95 active:scale-[0.99] transition-all cursor-pointer">
            Masuk ke Sistem
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <p class="text-xs text-gray-500">
            Belum memiliki akun peserta?
            <a href="{{ route('register') }}" class="font-semibold text-[#F97316] hover:underline">Daftar sekarang</a>
        </p>
    </div>

    <!-- Quick Demo Credential Autofill -->
    <div class="mt-6 pt-4 border-t border-dashed border-gray-200">
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider text-center mb-2.5">Akun Demo Pengujian</p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillDemo('admin@ecopoint.test', 'password')"
                class="py-2 px-2.5 text-xs text-center border border-amber-200 bg-amber-50/70 hover:bg-amber-100 text-amber-900 rounded-lg transition-colors cursor-pointer">
                <span class="block font-semibold">Admin Demo</span>
                <span class="text-[10px] text-amber-700">admin@ecopoint.test</span>
            </button>
            <button type="button" onclick="fillDemo('budi@ecopoint.test', 'password')"
                class="py-2 px-2.5 text-xs text-center border border-emerald-200 bg-emerald-50/70 hover:bg-emerald-100 text-emerald-900 rounded-lg transition-colors cursor-pointer">
                <span class="block font-semibold">Peserta Demo</span>
                <span class="text-[10px] text-emerald-700">budi@ecopoint.test</span>
            </button>
        </div>
    </div>
</div>

<script>
    function fillDemo(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
