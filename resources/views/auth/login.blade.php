@extends('layouts.app')

@section('title', 'Masuk ke Akun — StrikeStore')
@section('meta_description', 'Masuk ke akun StrikeStore Anda untuk melanjutkan pemesanan dan belanja perlengkapan memancing.')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 px-4 sm:px-6">
    <div class="max-w-md w-full bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">
                Masuk ke Akun
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Silakan masuk untuk melanjutkan belanja & checkout pesanan.
            </p>
        </div>

        {{-- Info Notice when redirected from Checkout --}}
        @if (str_contains(session('url.intended', ''), 'checkout'))
            <div class="mb-5 p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2.5">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Anda perlu <strong>masuk</strong> atau <a href="{{ route('register') }}" class="underline font-bold">daftar akun baru</a> terlebih dahulu sebelum melakukan checkout.</span>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="nama@email.com" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                />
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Masukkan kata sandi" 
                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <button 
                        type="button" 
                        onclick="togglePasswordVisibility()" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer"
                        aria-label="Tampilkan sandi"
                    >
                        <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500 cursor-pointer"
                    />
                    <span>Ingat saya</span>
                </label>
                <a href="https://wa.me/6285263785531" target="_blank" class="text-xs font-semibold text-emerald-700 hover:underline">
                    Lupa sandi? Hubungi Admin
                </a>
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-xl font-heading font-bold text-sm bg-[#064E3B] hover:bg-emerald-700 text-white transition-colors cursor-pointer"
            >
                Masuk
            </button>
        </form>

        {{-- Register Link --}}
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:text-emerald-800 underline ml-1">
                Buat Akun Baru
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const inputType = input.type === 'password' ? 'text' : 'password';
        input.type = inputType;
    }
</script>
@endpush
@endsection
