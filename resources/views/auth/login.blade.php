@extends('layouts.app')

@section('title', 'Masuk ke Akun Angler — StrikeStore')
@section('meta_description', 'Masuk ke akun StrikeStore Anda untuk menikmati kemudahan belanja perlengkapan memancing premium, pelacakan pesanan, dan promo eksklusif.')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-emerald-900/20 bg-white">
        
        {{-- LEFT COLUMN: BRAND STORY & PERKS --}}
        <div class="lg:col-span-5 bg-gradient-to-br from-[#022C22] via-[#064E3B] to-[#071C17] text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
            {{-- Background glow --}}
            <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-emerald-400/15 blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-block mb-8">
                    <x-logo size="default" />
                </a>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-950/80 text-emerald-300 border border-emerald-500/30 uppercase tracking-widest mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Angler Member Portal</span>
                </div>

                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight leading-tight mb-4">
                    Satu Akun untuk Semua Kebutuhan Strike Anda.
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100/80 leading-relaxed mb-8">
                    Nikmati kemudahan memantau pesanan joran, reel, dan piranti turnamen favorit Anda dengan aman dan cepat.
                </p>

                <div class="space-y-4 text-xs text-emerald-100/90">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span>100% Produk Original Bergaransi Resmi</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span>Standar Kemasan Pipa PVC Khusus Joran</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span>Poin Reward & Diskon Khusus Turnamen</span>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-emerald-900/60 text-[11px] text-emerald-200/60 relative z-10">
                Butuh bantuan login? Hubungi WhatsApp CS kami di <strong class="text-white">+62 812-3456-7890</strong>
            </div>
        </div>

        {{-- RIGHT COLUMN: LOGIN FORM --}}
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between bg-white">
            <div>
                <div class="mb-8">
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                        Masuk ke Akun
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1.5">
                        Masukkan email dan kata sandi Anda untuk mengakses akun StrikeStore.
                    </p>
                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        <div class="font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Gagal Masuk
                        </div>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5" id="loginForm">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                placeholder="nama@email.com" 
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            <a href="#" onclick="alert('Fitur reset sandi: Silakan hubungi admin WhatsApp StrikeStore untuk verifikasi akun.'); return false;" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                                Lupa sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="••••••••" 
                                class="w-full pl-10 pr-12 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600 focus:outline-none"
                                aria-label="Tampilkan atau sembunyikan kata sandi"
                            >
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500 cursor-pointer"
                        />
                        <label for="remember" class="ml-2 block text-xs text-slate-700 cursor-pointer select-none">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-4 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <span>Masuk ke Akun</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                {{-- Demo Account Quick Fill (For Review/Testing) --}}
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Akun Demo Pengujian Cepat:
                    </span>
                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            type="button" 
                            onclick="fillDemoAccount('bintang@strikestore.id', 'password')"
                            class="px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-left transition-colors cursor-pointer"
                        >
                            <div class="text-xs font-bold text-slate-800">Akun Angler / Pembeli</div>
                            <div class="text-[10px] text-slate-500">bintang@strikestore.id</div>
                        </button>
                        <button 
                            type="button" 
                            onclick="fillDemoAccount('admin@strikestore.id', 'password')"
                            class="px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-left transition-colors cursor-pointer"
                        >
                            <div class="text-xs font-bold text-slate-800">Akun Administrator</div>
                            <div class="text-[10px] text-slate-500">admin@strikestore.id</div>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer Register Link --}}
            <div class="mt-8 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
                Belum memiliki akun Angler?
                <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:text-emerald-800 underline ml-1">
                    Daftar Sekarang →
                </a>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const eye = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
        } else {
            input.type = 'password';
            eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    }

    function fillDemoAccount(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        showToast('Akun Diisi!', `Email: ${email} (Password: password)`);
    }
</script>
@endpush
@endsection
