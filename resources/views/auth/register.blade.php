@extends('layouts.app')

@section('title', 'Daftar Akun Angler Baru — StrikeStore')
@section('meta_description', 'Daftar akun baru di StrikeStore untuk menikmati promo turnamen, diskon eksklusif, dan kemudahan berbelanja alat pancing berkualitas.')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-emerald-900/20 bg-white">
        
        {{-- LEFT COLUMN: BRAND STORY --}}
        <div class="lg:col-span-5 bg-gradient-to-br from-[#022C22] via-[#064E3B] to-[#071C17] text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-emerald-400/15 blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-block mb-8">
                    <x-logo size="default" />
                </a>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-950/80 text-emerald-300 border border-emerald-500/30 uppercase tracking-widest mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Registrasi Angler Baru</span>
                </div>

                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight leading-tight mb-4">
                    Bergabung Bersama Komunitas Angler Terbaik.
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100/80 leading-relaxed mb-6">
                    Buat akun hanya dalam 1 menit dan dapatkan akses prioritas ke peluncuran produk joran dan reel terbaru.
                </p>

                <div class="space-y-3.5 text-xs text-emerald-100/90">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Voucher Diskon Angler Pemula 10%</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Konsultasi Pemilihan Piranti Gratis</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Garansi Resmi & Klaim Cepat</span>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-emerald-900/60 text-[11px] text-emerald-200/60 relative z-10">
                Keamanan data Anda terjamin dengan enkripsi modern StrikeStore.
            </div>
        </div>

        {{-- RIGHT COLUMN: REGISTER FORM --}}
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between bg-white">
            <div>
                <div class="mb-6">
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                        Daftar Akun Baru
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Isi formulir di bawah ini untuk menjadi member StrikeStore.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        <div class="font-bold mb-1">Gagal Mendaftar:</div>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Bintang Angler" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No. WhatsApp</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                            <input type="password" id="password" name="password" required placeholder="Min. 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi sandi" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <span>Daftar Akun Angler</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 underline ml-1">
                    Masuk ke Akun →
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
