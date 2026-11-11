@extends('layouts.app')

@section('title', 'StrikeStore — Toko Perlengkapan Memancing')
@section('meta_description', 'StrikeStore menyediakan perlengkapan memancing lengkap: joran, spinning reel, umpan lure, senar pancing, dan aksesori memancing.')

@section('content')
{{-- 1. HERO SECTION WITH UPLOADED FISHING GEAR BACKGROUND & FLOATING SEARCH BAR --}}
<section class="pt-6 pb-12 sm:pb-16 bg-white">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            {{-- Rounded Hero Container --}}
            <div class="relative rounded-[20px] overflow-hidden min-h-[440px] sm:min-h-[500px] flex items-center shadow-[0_20px_50px_-15px_rgba(16,45,66,0.22)]">
                {{-- Background Photo --}}
                <img 
                    src="{{ asset('images/hero-fishing-bg.jpg') }}" 
                    alt="StrikeStore Fishing Gear Background" 
                    class="absolute inset-0 w-full h-full object-cover object-center"
                />
                {{-- Navy Gradient Overlay for Readability --}}
                <div class="absolute inset-0 bg-gradient-to-r from-[#102D42]/95 via-[#194668]/80 to-[#102D42]/30"></div>

                {{-- Hero Text Content (Left Aligned like Reference) --}}
                <div class="relative z-10 w-full px-6 sm:px-12 lg:px-16 py-14 sm:py-20 pb-24 sm:pb-28 max-w-2xl">
                    <h1 class="font-heading font-extrabold text-3xl sm:text-5xl lg:text-[52px] text-white tracking-tight leading-[1.12] mb-5">
                        Gear Up. Cast Far. <span class="text-[#C5804B]">Strike Big.</span>
                    </h1>

                    <p class="font-sans font-normal text-sm sm:text-base text-[#DCE5EB] leading-relaxed mb-8 max-w-lg">
                        StrikeStore adalah destinasi utama perlengkapan memancing pilihan untuk setiap teknik—mulai dari casting, jigging, hingga turnamen laut dalam.
                    </p>

                    {{-- Translucent Pill Action Bar (Matching Reference Hero Pill) --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <a 
                            href="{{ route('catalog.index') }}" 
                            class="inline-flex items-center justify-between gap-6 pl-6 pr-4 py-3 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur-md border border-white/25 text-white text-sm font-sans font-semibold transition-all"
                        >
                            <span>Jelajahi Katalog Produk</span>
                            <span class="w-7 h-7 rounded-full bg-[#C5804B] text-white flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </a>
                        <a 
                            href="{{ route('cart.page') }}" 
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#194668]/80 hover:bg-[#194668] border border-[#DCE5EB]/30 text-white text-sm font-sans font-semibold transition-all"
                        >
                            <span>Keranjang & Checkout</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Floating Filter & Search Bar Overlapping Hero Bottom --}}
            <div class="relative z-20 -mt-10 sm:-mt-12 mx-auto max-w-4xl px-3 sm:px-6">
                <form 
                    action="{{ route('catalog.index') }}" 
                    method="GET" 
                    class="bg-white rounded-[18px] border border-[#E8EDF1] shadow-[0_18px_40px_-12px_rgba(16,45,66,0.14)] p-3 sm:p-4 grid grid-cols-1 sm:grid-cols-12 gap-3 sm:gap-4 items-center"
                >
                    {{-- Column 1: Kategori --}}
                    <div class="sm:col-span-4 px-3 py-1.5 sm:border-r border-[#E8EDF1]">
                        <label for="heroCategorySelect" class="block text-[11px] font-sans font-medium text-[#7A8791] mb-0.5">
                            Kategori Alat Pancing
                        </label>
                        <select 
                            id="heroCategorySelect" 
                            name="category" 
                            class="w-full text-sm font-heading font-bold text-[#202B35] bg-transparent focus:outline-none cursor-pointer"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Column 2: Kata Kunci / Brand --}}
                    <div class="sm:col-span-4 px-3 py-1.5 sm:border-r border-[#E8EDF1]">
                        <label for="heroSearchInput" class="block text-[11px] font-sans font-medium text-[#7A8791] mb-0.5">
                            Nama Produk / Brand
                        </label>
                        <input 
                            id="heroSearchInput"
                            type="text" 
                            name="search" 
                            placeholder="Shimano, Daiwa, Joran..." 
                            class="w-full text-sm font-heading font-bold text-[#202B35] placeholder-[#202B35]/60 bg-transparent focus:outline-none"
                        />
                    </div>

                    {{-- Column 3: Urutan --}}
                    <div class="sm:col-span-2 px-3 py-1.5">
                        <label for="heroSortSelect" class="block text-[11px] font-sans font-medium text-[#7A8791] mb-0.5">
                            Urutan
                        </label>
                        <select 
                            id="heroSortSelect" 
                            name="sort" 
                            class="w-full text-sm font-heading font-bold text-[#202B35] bg-transparent focus:outline-none cursor-pointer"
                        >
                            <option value="popular">Populer</option>
                            <option value="latest">Terbaru</option>
                            <option value="price_asc">Termurah</option>
                        </select>
                    </div>

                    {{-- Column 4: Search Button --}}
                    <div class="sm:col-span-2">
                        <button 
                            type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl bg-[#194668] hover:bg-[#102D42] text-white text-xs font-sans font-semibold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- 2. PRODUK PILIHAN / MOST VIEWED SECTION --}}
<section id="featured-section" class="py-14 sm:py-16 bg-white">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="font-heading font-bold text-2xl sm:text-3xl text-[#202B35]">
                Produk Pilihan & Terpopuler
            </h2>
            <p class="font-sans text-sm text-[#7A8791] mt-2 leading-relaxed">
                Temukan koleksi joran, reel, umpan, dan senar pancing berkualitas tinggi yang paling banyak diminati oleh para angler.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a 
                href="{{ route('catalog.index') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#F5F7F9] hover:bg-[#DCE5EB]/60 text-[#194668] text-xs font-sans font-semibold transition-colors border border-[#E8EDF1]"
            >
                <span>Lihat Seluruh Katalog Produk</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- 3. KATEGORI PERLENGKAPAN --}}
<section class="py-14 sm:py-16 bg-[#F5F7F9] border-y border-[#E8EDF1]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="font-heading font-bold text-2xl sm:text-3xl text-[#202B35]">
                    Kategori Perlengkapan
                </h2>
                <p class="font-sans text-sm text-[#7A8791] mt-1.5">
                    Pilih kategori produk sesuai teknik dan target memancing Anda
                </p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs sm:text-sm font-sans font-semibold text-[#194668] hover:text-[#102D42] shrink-0">
                Semua Kategori →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            @foreach ($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </div>
</section>

{{-- 4. FEATURE SPLIT SECTION (MATCHING REFERENCE "THE EASIEST METHOD" BLOCK) --}}
<section class="py-16 sm:py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            {{-- Left Rounded Feature Image --}}
            <div class="lg:col-span-6">
                <div class="relative rounded-[20px] overflow-hidden aspect-[16/10] bg-[#F5F7F9] border border-[#E8EDF1] shadow-[0_18px_40px_-15px_rgba(16,45,66,0.14)]">
                    <img 
                        src="{{ asset('images/hero-fishing-bg.jpg') }}" 
                        alt="Perlengkapan Memancing StrikeStore" 
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute top-4 right-4 w-12 h-12 rounded-2xl bg-white/25 backdrop-blur-md border border-white/40 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Right Text & CTA --}}
            <div class="lg:col-span-6 space-y-5">
                <h2 class="font-heading font-bold text-2xl sm:text-3xl lg:text-4xl text-[#202B35] leading-snug">
                    Cara Termudah Mendapatkan Alat Pancing Terbaik
                </h2>
                <p class="font-sans text-sm sm:text-base text-[#7A8791] leading-relaxed">
                    StrikeStore mempermudah Anda memilih perlengkapan pancing original dari rumah. Setiap produk telah melewati pemeriksaan kualitas ketat dan dikemas khusus menggunakan pipa PVC tebal agar tiba dengan aman.
                </p>
                <p class="font-sans text-sm text-[#7A8791] leading-relaxed">
                    Nikmati kemudahan mengatur keranjang belanja, mengisi data pemesanan secara cepat, hingga menyelesaikan transaksi pembayaran online menggunakan QRIS maupun Virtual Account.
                </p>
                <div class="pt-2">
                    <a 
                        href="{{ route('catalog.index') }}" 
                        class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-[#194668] hover:bg-[#102D42] text-white text-xs sm:text-sm font-sans font-semibold transition-all shadow-sm"
                    >
                        <span>Mulai Belanja Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. 3-STEP WORKFLOW SECTION (MATCHING REFERENCE "OUR WORK IN 3 STEPS") --}}
<section class="py-14 sm:py-18 bg-[#F5F7F9]/70 border-t border-[#E8EDF1]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="font-heading font-bold text-2xl sm:text-3xl text-[#202B35]">
                Belanja Mudah dalam 3 Langkah
            </h2>
            <p class="font-sans text-sm text-[#7A8791] mt-2 leading-relaxed">
                Proses pemesanan dan pembayaran online yang dirancang cepat, transparan, dan nyaman bagi setiap angler.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Step 1 --}}
            <div class="bg-white rounded-[18px] border border-[#E8EDF1] p-7 text-center product-card-hover">
                <div class="w-12 h-12 rounded-2xl bg-[#F5F7F9] border border-[#DCE5EB] text-[#194668] mx-auto flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-base text-[#202B35] mb-2">
                    Pilih Produk ke Keranjang
                </h3>
                <p class="font-sans text-xs text-[#7A8791] leading-relaxed">
                    Pilih joran, reel, umpan, atau senar pancing favorit Anda beserta varian dan jumlah yang diinginkan.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="bg-white rounded-[18px] border border-[#E8EDF1] p-7 text-center product-card-hover">
                <div class="w-12 h-12 rounded-2xl bg-[#F5F7F9] border border-[#DCE5EB] text-[#C5804B] mx-auto flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-base text-[#202B35] mb-2">
                    Isi Data Pemesanan
                </h3>
                <p class="font-sans text-xs text-[#7A8791] leading-relaxed">
                    Lengkapi nomor WhatsApp, alamat pengiriman lengkap, serta pilih layanan ekspedisi dan metode pembayaran.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white rounded-[18px] border border-[#E8EDF1] p-7 text-center product-card-hover">
                <div class="w-12 h-12 rounded-2xl bg-[#F5F7F9] border border-[#DCE5EB] text-[#194668] mx-auto flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-base text-[#202B35] mb-2">
                    Pembayaran Online & Kirim
                </h3>
                <p class="font-sans text-xs text-[#7A8791] leading-relaxed">
                    Bayar mudah via QRIS atau Virtual Account, unggah bukti bayar, dan pesanan langsung dikirim ke lokasi Anda.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
