@extends('layouts.app')

@section('title', $product->name . ' — StrikeStore')
@section('meta_description', Str::limit(strip_tags($product->description), 160))

@section('content')
@php
    $effectivePrice = $product->discount_price ?? $product->price;
    $hasDiscount = !empty($product->discount_price) && $product->discount_price < $product->price;
    $isOutOfStock = $product->status === 'out_of_stock' || $product->stock <= 0;
    $gallery = $product->gallery_list;
    $catSlug = $product->category?->slug ?? '';

    // Contextual realistic variants based on equipment category
    $variants = match($catSlug) {
        'joran' => ['165cm / ML Action', '180cm / Medium Action', '198cm / MH Action', '210cm / Heavy Action'],
        'reel' => ['Size 2000 (Shallow Spool)', 'Size 2500 HG (High Gear)', 'Size 3000 CXH (Compact)', 'Size 4000 Power', 'Size 5000 Heavy Duty'],
        'umpan' => ['Ayu Natural (15g)', 'Firetiger Glow (18g)', 'Red Head Pearl (20g)', 'Silver Sardine (22g)'],
        'senar' => ['PE 0.8 / 15 lbs (150m)', 'PE 1.2 / 22 lbs (200m)', 'PE 2.0 / 35 lbs (300m)', 'PE 3.0 / 48 lbs (300m)'],
        'kail-aksesori' => ['Size #1/0 (Isi 10)', 'Size #2/0 (Isi 8)', 'Size #3/0 (Isi 6)', 'Size #4/0 (Isi 5)'],
        default => ['Standar Factory', 'Turnamen Edition'],
    };
@endphp

{{-- Breadcrumb Navigation --}}
<div class="bg-white border-b border-slate-200/80 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-emerald-700 transition-colors">Katalog</a>
            <span>/</span>
            @if ($product->category)
                <a href="{{ route('catalog.category', $product->category->slug) }}" class="hover:text-emerald-700 transition-colors">
                    {{ $product->category->name }}
                </a>
                <span>/</span>
            @endif
            <span class="text-slate-900 font-semibold truncate max-w-xs">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    {{-- Two Column Layout: Left Gallery, Right Details --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
        
        {{-- LEFT COLUMN: PRODUCT IMAGE GALLERY --}}
        <div class="lg:col-span-6 space-y-4">
            {{-- Main Featured Image Viewer --}}
            <div class="relative w-full aspect-[4/3] sm:aspect-square bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex items-center justify-center p-6 group">
                <img 
                    id="mainProductImage"
                    src="{{ $product->image_url }}" 
                    alt="{{ $product->name }}" 
                    class="w-full h-full object-cover rounded-2xl transition-all duration-300 group-hover:scale-105"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=800&q=80';"
                />

                {{-- Badges --}}
                <div class="absolute top-4 left-4 flex flex-col gap-1.5 z-10">
                    @if ($hasDiscount)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-600 text-white shadow-md">
                            HEMAT {{ $product->discount_percentage }}%
                        </span>
                    @endif
                    @if ($product->is_featured)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-white shadow-md flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Pilihan Utama Angler
                        </span>
                    @endif
                </div>

                {{-- Stock Tag --}}
                <div class="absolute top-4 right-4 z-10">
                    @if ($isOutOfStock)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-900/90 text-slate-200 backdrop-blur-md">
                            Stok Habis
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-700/90 text-white backdrop-blur-md flex items-center gap-1.5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                            Stok Siap Kirim ({{ $product->stock }} unit)
                        </span>
                    @endif
                </div>
            </div>

            {{-- Interactive Thumbnail Carousel/Row --}}
            <div class="flex items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                @foreach ($gallery as $index => $imgUrl)
                    <button 
                        type="button" 
                        onclick="switchMainImage('{{ $imgUrl }}', this)"
                        class="thumb-btn relative w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border-2 overflow-hidden bg-white shrink-0 p-1 transition-all duration-200 cursor-pointer {{ $index === 0 ? 'border-emerald-600 ring-2 ring-emerald-500/20 shadow-sm' : 'border-slate-200 opacity-70 hover:opacity-100' }}"
                        aria-label="Lihat gambar produk {{ $index + 1 }}"
                    >
                        <img 
                            src="{{ $imgUrl }}" 
                            alt="{{ $product->name }} thumb {{ $index + 1 }}" 
                            class="w-full h-full object-cover rounded-xl"
                        />
                    </button>
                @endforeach
            </div>

            {{-- Delivery & Guarantee Highlights --}}
            <div class="grid grid-cols-2 gap-3 pt-2">
                <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 flex items-center gap-3 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-800">100% Produk Original</div>
                        <div class="text-[11px] text-slate-400">Garansi resmi distributor</div>
                    </div>
                </div>
                <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 flex items-center gap-3 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-800">Kemasan Khusus Pipa PVC</div>
                        <div class="text-[11px] text-slate-400">Aman terlindungi saat kirim</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: PRODUCT INFO & ORDER ACTIONS --}}
        <div class="lg:col-span-6 space-y-6">
            {{-- Category & Brand info --}}
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    @if ($product->category)
                        <a href="{{ route('catalog.category', $product->category->slug) }}" class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                            {{ $product->category->name }}
                        </a>
                    @endif
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                        Brand: {{ $product->brand }}
                    </span>
                </div>
                <span class="text-xs font-mono text-slate-400">SKU: {{ $product->sku ?? '-' }}</span>
            </div>

            {{-- Title --}}
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 tracking-tight leading-tight">
                {{ $product->name }}
            </h1>

            {{-- Rating & Review Summary --}}
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center text-amber-400">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $product->rating_score }} / 5.0</span>
                <span class="text-xs text-slate-400">({{ $product->review_count }} ulasan pembeli terverifikasi)</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-500">{{ number_format($product->views_count) }}x dilihat</span>
            </div>

            {{-- Price Highlight Box --}}
            <div class="p-6 rounded-3xl bg-gradient-to-r from-emerald-950 via-[#064E3B] to-[#022C22] text-white shadow-xl border border-emerald-500/30">
                <div class="text-xs text-emerald-300 font-bold uppercase tracking-wider mb-1">Harga Terbaik Angler</div>
                <div class="flex items-baseline gap-3 flex-wrap">
                    <span class="font-heading font-extrabold text-3xl sm:text-4xl text-white">
                        Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                    </span>
                    @if ($hasDiscount)
                        <span class="text-sm sm:text-base text-emerald-200/60 line-through">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500 text-white shadow-xs">
                            Hemat Rp {{ number_format($product->price - $product->discount_price, 0, ',', '.') }}
                        </span>
                    @endif
                </div>
                <div class="text-[11px] text-emerald-200/80 mt-2 flex items-center gap-1.5">
                    <span>⚡ Pembayaran aman dengan Virtual Account BCA/Mandiri/BRI & QRIS</span>
                </div>
            </div>

            {{-- Product Variants Selection --}}
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Pilih Varian / Spesifikasi:
                    </span>
                    <span id="activeVariantDisplay" class="text-xs font-bold text-emerald-700">
                        {{ $variants[0] }}
                    </span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-2" id="variantOptionsContainer">
                    @foreach ($variants as $idx => $v)
                        <button 
                            type="button" 
                            onclick="selectVariant('{{ $v }}', this)"
                            class="variant-btn px-3.5 py-2.5 rounded-xl border text-xs font-semibold text-left transition-all cursor-pointer {{ $idx === 0 ? 'border-emerald-600 bg-emerald-50 text-emerald-900 ring-1 ring-emerald-500' : 'border-slate-200 hover:border-slate-300 bg-slate-50 text-slate-700' }}"
                        >
                            {{ $v }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" id="selectedVariantInput" value="{{ $variants[0] }}">
            </div>

            {{-- Short Description --}}
            <div class="prose prose-sm text-slate-600 leading-relaxed">
                <h3 class="font-heading font-bold text-base text-slate-900 mb-2">Ringkasan Produk</h3>
                <p class="whitespace-pre-line text-sm text-slate-700">{{ $product->description }}</p>
            </div>

            {{-- Order Controls (Quantity & Actions) --}}
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-sm space-y-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jumlah Pesanan</span>
                        <div class="inline-flex items-center border-2 border-slate-200 rounded-xl bg-slate-50 overflow-hidden">
                            <button 
                                type="button" 
                                onclick="adjustDetailQty(-1)"
                                class="px-3.5 py-2 hover:bg-slate-200 font-extrabold text-slate-700 transition-colors cursor-pointer"
                                aria-label="Kurangi jumlah"
                            >
                                -
                            </button>
                            <input 
                                type="number" 
                                id="detailQtyInput" 
                                value="1" 
                                min="1" 
                                max="{{ $product->stock }}"
                                class="w-14 text-center font-heading font-bold text-sm bg-transparent border-none focus:outline-none focus:ring-0 text-slate-900"
                                onchange="validateDetailQty(this)"
                            />
                            <button 
                                type="button" 
                                onclick="adjustDetailQty(1)"
                                class="px-3.5 py-2 hover:bg-slate-200 font-extrabold text-slate-700 transition-colors cursor-pointer"
                                aria-label="Tambah jumlah"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="block text-xs text-slate-400 mb-1">Status Ketersediaan:</span>
                        @if ($isOutOfStock)
                            <span class="font-bold text-sm text-rose-600">Stok Kosong</span>
                        @else
                            <span class="font-bold text-sm text-emerald-800">{{ $product->stock }} unit siap kirim</span>
                        @endif
                    </div>
                </div>

                {{-- CTA Buttons: Add to Cart & Buy Now --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    @if ($isOutOfStock)
                        <button 
                            type="button" 
                            disabled 
                            class="sm:col-span-2 py-4 px-6 rounded-xl bg-slate-200 text-slate-400 font-bold text-sm cursor-not-allowed text-center"
                        >
                            Stok Saat Ini Tidak Tersedia
                        </button>
                    @else
                        {{-- Add to Cart --}}
                        <button 
                            type="button"
                            id="detailAddToCartBtn"
                            onclick="handleDetailAddToCart()"
                            class="py-4 px-6 rounded-xl font-heading font-bold text-sm bg-[#064E3B] hover:bg-emerald-700 text-white shadow-lg shadow-emerald-950/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Tambah ke Keranjang</span>
                        </button>

                        {{-- Buy Now --}}
                        <button 
                            type="button"
                            onclick="handleDetailBuyNow()"
                            class="py-4 px-6 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 shadow-lg shadow-amber-900/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Beli Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Specifications & Info Accordions --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm space-y-4">
                <h3 class="font-heading font-bold text-base text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Spesifikasi & Panduan Angler
                </h3>

                <dl class="divide-y divide-slate-100 text-xs">
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">SKU Produk</dt>
                        <dd class="text-slate-900 font-mono font-bold" id="detailSkuDisplay">{{ $product->sku ?? '-' }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">Kategori</dt>
                        <dd class="text-slate-900 font-semibold">{{ $product->category?->name ?? 'Peralatan Mancing' }}</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">Brand / Manufaktur</dt>
                        <dd class="text-slate-900 font-semibold">{{ $product->brand }}</dd>
                    </div>
                    @if ($product->weight)
                        <div class="py-2.5 flex justify-between">
                            <dt class="text-slate-500 font-medium">Berat Barang</dt>
                            <dd class="text-slate-900 font-semibold">{{ number_format($product->weight, 0, ',', '.') }} gram</dd>
                        </div>
                    @endif
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">Garansi Resmi</dt>
                        <dd class="text-slate-900 font-semibold">1 Tahun Distributor Resmi</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">Kondisi Barang</dt>
                        <dd class="text-emerald-700 font-bold">100% Baru, Segel Pabrik Original</dd>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <dt class="text-slate-500 font-medium">Standar Pengiriman</dt>
                        <dd class="text-slate-800 font-medium">Pipa PVC Tebal + Bubble Wrap (Khusus Joran)</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>

    {{-- CUSTOMER REVIEWS SECTION --}}
    <div class="mt-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100">
            <div>
                <h3 class="font-heading font-extrabold text-2xl text-slate-900">Ulasan Angler Terverifikasi</h3>
                <p class="text-xs text-slate-500 mt-1">Berdasarkan {{ $product->review_count }} penilaian pembeli yang telah menerima produk</p>
            </div>
            <div class="flex items-center gap-4 bg-emerald-50 px-5 py-3 rounded-2xl border border-emerald-100">
                <div class="text-3xl font-heading font-extrabold text-emerald-900">{{ $product->rating_score }}</div>
                <div>
                    <div class="flex text-amber-400 text-sm">★★★★★</div>
                    <div class="text-[11px] text-emerald-700 font-semibold">98% Angler Merekomendasikan</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-xs text-slate-900">Rian H. (Turnamen Angler)</span>
                    <span class="text-[10px] text-slate-400">2 hari lalu</span>
                </div>
                <div class="text-amber-400 text-xs mb-1.5">★★★★★</div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    "Barang original 100%. Kemasan pipa paralon rapi dan kokoh, sampai di Lampung tanpa cacat. Kualitas sesuai dengan deskripsi resmi."
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-xs text-slate-900">Agus Salim</span>
                    <span class="text-[10px] text-slate-400">1 minggu lalu</span>
                </div>
                <div class="text-amber-400 text-xs mb-1.5">★★★★★</div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    "Respons admin sangat cepat di WhatsApp saat konsultasi varian. Sudah dicoba casting di muara, putaran sangat presisi."
                </p>
            </div>
        </div>
    </div>

    {{-- RELATED PRODUCTS SECTION --}}
    @if ($relatedProducts->count() > 0)
        <div class="mt-16 pt-12 border-t border-slate-200">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Rekomendasi Terbaik</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-0.5">
                        Produk Terkait Lainnya
                    </h2>
                </div>
                @if ($product->category)
                    <a href="{{ route('catalog.category', $product->category->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        <span>Lihat Kategori {{ $product->category->name }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Detail Page Scripts --}}
@push('scripts')
<script>
    const maxProductStock = {{ $product->stock }};
    const baseSku = "{{ $product->sku ?? 'STRK' }}";

    // Thumbnail Switcher
    function switchMainImage(newSrc, btn) {
        const mainImg = document.getElementById('mainProductImage');
        mainImg.style.opacity = '0.5';
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 120);

        document.querySelectorAll('.thumb-btn').forEach(b => {
            b.classList.remove('border-emerald-600', 'ring-2', 'ring-emerald-500/20');
            b.classList.add('border-slate-200', 'opacity-70');
        });

        btn.classList.remove('border-slate-200', 'opacity-70');
        btn.classList.add('border-emerald-600', 'ring-2', 'ring-emerald-500/20', 'opacity-100');
    }

    // Variant Selection
    function selectVariant(variantName, btn) {
        document.getElementById('selectedVariantInput').value = variantName;
        document.getElementById('activeVariantDisplay').textContent = variantName;

        document.querySelectorAll('.variant-btn').forEach(b => {
            b.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-900', 'ring-1', 'ring-emerald-500');
            b.classList.add('border-slate-200', 'bg-slate-50', 'text-slate-700');
        });

        btn.classList.remove('border-slate-200', 'bg-slate-50', 'text-slate-700');
        btn.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-900', 'ring-1', 'ring-emerald-500');
    }

    // Stepper Quantity
    function adjustDetailQty(delta) {
        const input = document.getElementById('detailQtyInput');
        let current = parseInt(input.value) || 1;
        let next = current + delta;
        if (next < 1) next = 1;
        if (next > maxProductStock) next = maxProductStock;
        input.value = next;
    }

    function validateDetailQty(input) {
        let val = parseInt(input.value) || 1;
        if (val < 1) val = 1;
        if (val > maxProductStock) val = maxProductStock;
        input.value = val;
    }

    // Add to cart from detail
    function handleDetailAddToCart() {
        const qty = parseInt(document.getElementById('detailQtyInput').value) || 1;
        const variant = document.getElementById('selectedVariantInput').value;
        const btn = document.getElementById('detailAddToCartBtn');
        addToCart({{ $product->id }}, qty, btn, variant);
    }

    // Buy now
    function handleDetailBuyNow() {
        const qty = parseInt(document.getElementById('detailQtyInput').value) || 1;
        const variant = document.getElementById('selectedVariantInput').value;
        addToCart({{ $product->id }}, qty, null, variant);
        setTimeout(() => {
            proceedToCheckout();
        }, 500);
    }
</script>
@endpush
@endsection
