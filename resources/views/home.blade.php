@extends('layouts.app')

@section('title', 'StrikeStore — Toko Perlengkapan Memancing Premium')
@section('meta_description', 'StrikeStore menyediakan perlengkapan memancing terlengkap dan premium: joran, spinning reel, umpan lure, senar pancing, dan aksesori memancing.')

@section('content')
{{-- HERO SECTION --}}
<section class="relative bg-gradient-to-br from-[#022C22] via-[#064E3B] to-[#071C17] text-white overflow-hidden border-b border-emerald-900/60 pt-12 pb-20 lg:py-24">
    {{-- Decorative Background Elements & Gradients --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(16,185,129,0.25),rgba(255,255,255,0))] pointer-events-none"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-teal-500/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            {{-- Left Column: Copywriting & CTA --}}
            <div class="lg:col-span-7 text-center lg:text-left">
                {{-- Eyebrow badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/80 border border-emerald-400/30 text-emerald-300 text-xs font-bold tracking-widest uppercase mb-6 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>PREMIUM FISHING EQUIPMENT</span>
                </div>

                {{-- Hero Heading --}}
                <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight leading-[1.1] mb-6">
                    Gear Up. Cast Far. <br class="hidden sm:inline" />
                    <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200 bg-clip-text text-transparent">
                        Strike Big.
                    </span>
                </h1>

                {{-- Description --}}
                <p class="text-base sm:text-lg text-emerald-100/80 max-w-2xl mx-auto lg:mx-0 leading-relaxed mb-8">
                    Temukan joran sensitif berbahan solid carbon, reel berkekuatan drag monster, umpan berenang realistis, dan senar tangguh dari brand pancing terkemuka di dunia. Dirancang khusus untuk memuaskan adrenalin angler sejati.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a 
                        href="{{ route('catalog.index') }}" 
                        class="w-full sm:w-auto px-8 py-4 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-slate-950 shadow-xl shadow-emerald-950/50 hover:shadow-emerald-500/30 active:scale-95 transition-all text-center flex items-center justify-center gap-2 group cursor-pointer"
                    >
                        <span>Explore Collection</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    <a 
                        href="#featured-section" 
                        class="w-full sm:w-auto px-8 py-4 rounded-xl font-heading font-bold text-sm bg-[#071C17]/80 hover:bg-[#071C17] text-white border border-slate-600 hover:border-emerald-400/60 shadow-lg active:scale-95 transition-all text-center flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <span>Shop Best Sellers</span>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </a>
                </div>

                {{-- Trust Metrics --}}
                <div class="grid grid-cols-3 gap-4 pt-10 mt-10 border-t border-emerald-900/60 max-w-md mx-auto lg:mx-0">
                    <div>
                        <div class="font-heading font-extrabold text-2xl sm:text-3xl text-emerald-300">25+</div>
                        <div class="text-xs text-emerald-200/70 mt-0.5">Produk Pilihan</div>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white">5.0 ★</div>
                        <div class="text-xs text-emerald-200/70 mt-0.5">Rating Angler</div>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-2xl sm:text-3xl text-emerald-300">100%</div>
                        <div class="text-xs text-emerald-200/70 mt-0.5">Original Brand</div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Dynamic Visual Spotlight Showcase --}}
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    {{-- Decorative Glow Ring --}}
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-3xl blur-xl opacity-30 group-hover:opacity-100 transition duration-1000"></div>
                    
                    {{-- Featured Reel / Rod Showcase Card --}}
                    <div class="relative rounded-3xl bg-[#071C17] border border-emerald-500/40 p-6 shadow-2xl overflow-hidden metallic-shine group">
                        <a href="{{ route('catalog.show', 'reel-penn-battle-iii-5000-heavy-duty') }}" class="block aspect-square rounded-2xl overflow-hidden bg-gradient-to-b from-slate-900 via-[#064E3B]/40 to-[#022C22] relative flex items-center justify-center p-4">
                            <img 
                                src="https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?auto=format&fit=crop&w=800&q=80" 
                                alt="Reel Penn Battle III 5000 Heavy Duty" 
                                class="w-full h-full object-cover rounded-xl shadow-inner transition-transform duration-500 group-hover:scale-105"
                            />
                            
                            {{-- Badges floating on hero visual --}}
                            <div class="absolute top-4 left-4 bg-emerald-950/90 border border-emerald-400/40 text-emerald-300 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md flex items-center gap-1.5 shadow-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>Turnamen Ready</span>
                            </div>

                            <div class="absolute bottom-4 right-4 bg-slate-950/80 border border-slate-700 text-white px-3 py-1 rounded-full text-xs font-mono backdrop-blur-md">
                                HT-100 Carbon Drag
                            </div>
                        </a>

                        {{-- Floating Highlight Spec & Direct Action --}}
                        <div class="mt-5 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider">Spotlight Reel Terbaik</span>
                                <h4 class="font-heading font-bold text-lg text-white group-hover:text-emerald-300 transition-colors">
                                    <a href="{{ route('catalog.show', 'reel-penn-battle-iii-5000-heavy-duty') }}">
                                        Reel Penn Battle III 5000
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-400">Full Metal Body • CNC Gear Technology</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-slate-400 line-through">Rp 1.750.000</span>
                                <div class="font-heading font-extrabold text-xl text-emerald-400">Rp 1.590.000</div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-emerald-950 flex items-center justify-between">
                            <a href="{{ route('catalog.show', 'reel-penn-battle-iii-5000-heavy-duty') }}" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                                <span>Lihat Spesifikasi & Varian</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <button 
                                type="button" 
                                onclick="addToCart(10, 1, this)"
                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-500 text-slate-950 text-xs font-bold hover:brightness-110 active:scale-95 transition-all shadow-md cursor-pointer"
                            >
                                + Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 2. EXPLORE CATEGORIES SECTION --}}
<section class="py-16 sm:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-extrabold tracking-widest text-emerald-700 uppercase">
                    Koleksi Perlengkapan
                </span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 mt-1">
                    Explore Categories
                </h2>
                <p class="text-slate-500 text-sm mt-2 max-w-xl">
                    Pilih kategori alat memancing yang dirancang khusus untuk berbagai teknik: casting, jigging, popping, hingga galatama.
                </p>
            </div>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 group">
                <span>Lihat Semua Katalog</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        {{-- Categories Grid (5 categories) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @foreach ($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </div>
</section>

{{-- 3. FEATURED PRODUCTS SECTION --}}
<section id="featured-section" class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-extrabold tracking-widest text-emerald-700 uppercase">
                    Pilihan Utama Angler
                </span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 mt-1">
                    Featured Products & Best Sellers
                </h2>
                <p class="text-slate-500 text-sm mt-2 max-w-xl">
                    Produk dengan tingkat kehandalan tertinggi, ulasan terbaik, dan paling banyak diincar angler profesional Indonesia.
                </p>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'popular']) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 group">
                <span>Lihat Koleksi Lengkap</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

{{-- 4. BRAND VALUE SECTION (WITH CLEAN SVGS) --}}
<section class="py-16 sm:py-20 bg-gradient-to-br from-[#022C22] via-[#064E3B] to-[#071C17] text-white relative overflow-hidden border-y border-emerald-900/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-extrabold tracking-widest text-emerald-400 uppercase">
                Standar Kualitas StrikeStore
            </span>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-white mt-1">
                The StrikeStore Standard
            </h2>
            <p class="text-emerald-200/80 text-sm mt-3">
                Kami memahami pentingnya keandalan setiap sambungan senar, kekuatan blank joran, dan kehalusan drag reel saat bertarung melawan ikan target.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Value 1: Quality Fishing Gear --}}
            <div class="p-6 rounded-2xl bg-[#071C17]/80 border border-emerald-500/30 backdrop-blur-md shadow-lg flex flex-col items-center text-center group hover:border-emerald-400/60 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 mb-4 shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-white mb-2">Quality Fishing Gear</h3>
                <p class="text-xs text-emerald-100/70 leading-relaxed">
                    Setiap joran, reel, dan lure melewati uji kualitas material ketat untuk memastikan performa tangguh di air tawar maupun laut.
                </p>
            </div>

            {{-- Value 2: Trusted Product Selection --}}
            <div class="p-6 rounded-2xl bg-[#071C17]/80 border border-emerald-500/30 backdrop-blur-md shadow-lg flex flex-col items-center text-center group hover:border-emerald-400/60 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 mb-4 shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-white mb-2">Trusted Product Selection</h3>
                <p class="text-xs text-emerald-100/70 leading-relaxed">
                    Hanya menghadirkan lini produk dari manufaktur ternama dunia seperti Shimano, Daiwa, Mustad, Rapala, dan Relix Nusantara.
                </p>
            </div>

            {{-- Value 3: Secure Shopping & Safe Pipe Packaging --}}
            <div class="p-6 rounded-2xl bg-[#071C17]/80 border border-emerald-500/30 backdrop-blur-md shadow-lg flex flex-col items-center text-center group hover:border-emerald-400/60 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 mb-4 shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-white mb-2">Secure Shopping</h3>
                <p class="text-xs text-emerald-100/70 leading-relaxed">
                    Transaksi aman dan terlindungi dengan sistem verifikasi langsung, pengemasan pipa PVC ekstra aman untuk pengiriman joran.
                </p>
            </div>

            {{-- Value 4: Support for Every Angler --}}
            <div class="p-6 rounded-2xl bg-[#071C17]/80 border border-emerald-500/30 backdrop-blur-md shadow-lg flex flex-col items-center text-center group hover:border-emerald-400/60 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-emerald-900/60 border border-emerald-400/30 flex items-center justify-center text-emerald-400 mb-4 shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-white mb-2">Support for Every Angler</h3>
                <p class="text-xs text-emerald-100/70 leading-relaxed">
                    Dukungan angler specialist kami siap memberikan rekomendasi piranti terbaik sesuai target spot dan teknik memancing Anda.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 5. TESTIMONIALS / SUARA ANGLER --}}
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold tracking-widest text-emerald-700 uppercase">
                Testimoni Komunitas
            </span>
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">
                Dipercaya Angler Seluruh Indonesia
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Review 1 --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 mb-3 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                        "Reel Penn Battle III dari StrikeStore beneran badak. Drag halus, tenggiri 12kg naik tanpa kendala sama sekali. Pengiriman cepat dan barang 100% original."
                    </p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-900">Bambang S.</div>
                        <div class="text-[11px] text-slate-400">Angler Laut Dalam — Jakarta</div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Verified Buyer</span>
                </div>
            </div>

            {{-- Review 2 --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 mb-3 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                        "Joran Relix Nusantara Cangkek packing pipa paralonnya tebal banget. Aman sampai tujuan tanpa gores. Sensasi lenturnya luar biasa untuk ultra light casting."
                    </p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-900">Andi Pratama</div>
                        <div class="text-[11px] text-slate-400">UL Specialist — Surabaya</div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Verified Buyer</span>
                </div>
            </div>

            {{-- Review 3 --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 mb-3 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                        "Pelayanan CS sangat informatif saat tanya perbandingan ukuran spool reel Daiwa vs Shimano. Belanja di StrikeStore selalu memuaskan."
                    </p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-900">Hendra Wijaya</div>
                        <div class="text-[11px] text-slate-400">Galatama Angler — Bandung</div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Verified Buyer</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 6. PROMOTIONAL CALL TO ACTION BANNER --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl bg-gradient-to-r from-[#022C22] via-[#064E3B] to-[#071C17] border border-emerald-500/40 p-8 sm:p-12 lg:p-16 overflow-hidden shadow-2xl metallic-shine">
            {{-- Decorative circles --}}
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-emerald-400/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-400 text-slate-950 uppercase tracking-wider mb-4">
                    Musim Memancing Tiba
                </span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                    Ready for Your Next Adventure?
                </h2>
                <p class="text-emerald-100/80 text-sm sm:text-base mt-4 leading-relaxed">
                    Tingkatkan peluang strike Anda dengan peralatan memancing berkualitas turnamen. Belanja sekarang dan nikmati penawaran harga khusus serta gratis ongkir.
                </p>
                <div class="mt-8 flex flex-wrap gap-4 items-center">
                    <a 
                        href="{{ route('catalog.index') }}" 
                        class="px-8 py-3.5 rounded-xl font-heading font-bold text-sm bg-white hover:bg-slate-100 text-[#022C22] shadow-lg shadow-black/20 transition-all active:scale-95 text-center cursor-pointer"
                    >
                        Discover the Collection
                    </a>
                    <a 
                        href="{{ route('catalog.category', 'joran') }}" 
                        class="px-6 py-3.5 rounded-xl font-heading font-bold text-sm bg-transparent hover:bg-white/10 text-white border border-emerald-400/60 transition-all text-center cursor-pointer"
                    >
                        Lihat Joran Terbaru →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
