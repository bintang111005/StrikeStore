@extends('layouts.app')

@section('title', 'Daftar Akun Baru — StrikeStore')
@section('meta_description', 'Buat akun StrikeStore untuk mempermudah pemesanan dan pengiriman perlengkapan memancing.')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 px-4 sm:px-6">
    <div class="max-w-md w-full bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">
                Daftar Akun Baru
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Isi data singkat di bawah ini untuk mulai memesan produk.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Username / Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    placeholder="Contoh: Bintang Pratama" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                />
                <p class="text-[11px] text-slate-400 mt-1">Nama ini akan otomatis terisi saat Anda melakukan checkout.</p>
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Email <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    placeholder="nama@email.com" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                />
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5">
                    No. HP / WhatsApp
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    placeholder="Contoh: 085263785531" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                />
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Alamat Pengiriman (Opsional)
                </label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="2" 
                    placeholder="Alamat lengkap pengiriman..." 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Min. 6 karakter" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Ulangi Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        placeholder="Ulangi kata sandi" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    />
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-xl font-heading font-bold text-sm bg-[#194668] hover:bg-emerald-700 text-white transition-colors cursor-pointer mt-2"
            >
                Daftar & Masuk
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 underline ml-1">
                Masuk di sini
            </a>
        </div>
    </div>
</div>
@endsection
