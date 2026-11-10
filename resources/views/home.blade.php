@extends('layouts.app')

@section('title', 'StrikeStore — Toko Perlengkapan Memancing')
@section('meta_description', 'StrikeStore menyediakan perlengkapan memancing lengkap: joran, spinning reel, umpan lure, senar pancing, dan aksesori memancing.')

@section('content')
{{-- 1. SIMPLE & CLEAN HERO SECTION --}}
<section class="bg-[#022C22] text-white py-14 sm:py-20 border-b border-emerald-900/60">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-900/60 border border-emerald-500/30 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-5">
            Perlengkapan Memancing Lengkap
        </span>

        <h1 class="font-heading font-extrabold text-3xl sm:text-5xl text-white tracking-tight leading-tight mb-4">
            Gear Up. Cast Far. <span class="text-emerald-400">Strike Big.</span>
        </h1>

        <p class="text-sm sm:text-base text-emerald-100/80 max-w-2xl mx-auto leading-relaxed mb-8">
            Temukan joran, reel, umpan, senar, dan aksesori pancing pilihan dengan proses belanja yang mudah, cepat, dan aman.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <a 
                href="{{ route('catalog.index') }}" 
                class="px-7 py-3.5 rounded-xl font-heading font-bold text-sm bg-emerald-500 hover:bg-emerald-400 text-slate-950 transition-all shadow-md"
            >
                Lihat Katalog Produk
            </a>
            <a 
                href="{{ route('cart.page') }}" 
                class="px-7 py-3.5 rounded-xl font-heading font-bold text-sm bg-white/10 hover:bg-white/15 text-white border border-white/20 transition-all"
            >
                Keranjang & Checkout
            </a>
        </div>
    </div>
</section>

{{-- 2. KATEGORI PRODUK --}}
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900">
                    Kategori Perlengkapan
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                    Pilih kategori produk sesuai kebutuhan memancing Anda
                </p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs sm:text-sm font-bold text-emerald-700 hover:underline shrink-0">
                Semua Produk →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach ($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </div>
</section>

{{-- 3. PRODUK UNGGULAN --}}
<section id="featured-section" class="py-12 sm:py-16 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900">
                    Produk Pilihan
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                    Koleksi perlengkapan pancing yang siap Anda pesan
                </p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs sm:text-sm font-bold text-emerald-700 hover:underline shrink-0">
                Lihat Katalog Lengkap →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>
@endsection
