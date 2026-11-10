@extends('layouts.app')

@section('title', 'Keranjang Belanja — StrikeStore')
@section('meta_description', 'Kelola keranjang belanja perlengkapan memancing Anda di StrikeStore. Pilih produk dan lanjutkan ke pengisian data pemesanan dengan mudah.')

@section('content')
{{-- Top Step Progress Header --}}
<div class="bg-white border-b border-slate-200/80 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('catalog.index') }}" class="hover:text-emerald-700 transition-colors">Katalog</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Keranjang Belanja</span>
                </nav>
                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Keranjang Belanja Anda
                </h1>
            </div>

            {{-- Simple 3-Step Indicator --}}
            <div class="flex items-center gap-2 sm:gap-3 text-xs font-semibold">
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#064E3B] text-white shadow-sm">
                    <span class="w-5 h-5 rounded-full bg-emerald-400 text-slate-950 font-extrabold flex items-center justify-center text-[11px]">1</span>
                    <span>Pilih Produk</span>
                </div>
                <svg class="w-4 h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('checkout.index') }}" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-emerald-50 hover:text-emerald-800 transition-colors">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center text-[11px]">2</span>
                    <span>Data Pemesanan</span>
                </a>
                <svg class="w-4 h-4 text-slate-300 shrink-0 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <div class="hidden sm:flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 text-slate-400">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-500 font-bold flex items-center justify-center text-[11px]">3</span>
                    <span>Selesai</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    @if (count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- LEFT COLUMN: CART ITEMS & SELECTION (2 cols) --}}
            <div class="lg:col-span-2 space-y-4">
                
                {{-- Free Shipping Banner --}}
                <div class="p-4 rounded-2xl bg-emerald-50/90 border border-emerald-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                        <div class="text-xs sm:text-sm text-emerald-950" id="cartPageShippingText">
                            @if ($summary['is_free_shipping'])
                                <span class="font-bold text-emerald-800">🎉 Selamat! Pesanan Anda mendapat Gratis Ongkir!</span>
                            @else
                                Tambah belanja <strong class="font-extrabold text-emerald-800">Rp {{ number_format($summary['remaining_free_shipping'], 0, ',', '.') }}</strong> lagi untuk klaim <strong>Gratis Ongkir</strong>!
                            @endif
                        </div>
                    </div>
                    <div class="w-full sm:w-40 bg-emerald-200/70 rounded-full h-2.5 overflow-hidden shrink-0">
                        <div id="cartPageShippingBar" class="bg-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $summary['shipping_progress'] }}%"></div>
                    </div>
                </div>

                {{-- Select All & Clear Toolbar --}}
                <div class="bg-white rounded-2xl border border-slate-200/90 px-5 py-3.5 flex items-center justify-between gap-4 shadow-xs">
                    @php
                        $allSelected = collect($cartItems)->every(fn($i) => $i['selected'] ?? true);
                    @endphp
                    <label class="inline-flex items-center gap-3 cursor-pointer select-none">
                        <input 
                            type="checkbox" 
                            id="selectAllCartCheckbox"
                            {{ $allSelected ? 'checked' : '' }}
                            onchange="toggleSelectAllCart(this.checked)"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                        />
                        <span class="text-xs sm:text-sm font-bold text-slate-800">
                            Pilih Semua Produk (<span id="totalCartProductsCount">{{ count($cartItems) }}</span>)
                        </span>
                    </label>

                    <div class="flex items-center gap-4">
                        <a href="#pilih-produk-cepat" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Produk</span>
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan seluruh isi keranjang belanja?')">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus Semua</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Cart Item Cards --}}
                <div class="space-y-3" id="cartPageItemsList">
                    @foreach ($cartItems as $item)
                        @php
                            $catSlug = $item['category_slug'] ?? '';
                            $variantOptions = match($catSlug) {
                                'joran' => ['165cm / ML Action', '180cm / Medium Action', '198cm / MH Action', '210cm / Heavy Action'],
                                'reel' => ['Size 2000 (Shallow Spool)', 'Size 2500 HG (High Gear)', 'Size 3000 CXH (Compact)', 'Size 4000 Power', 'Size 5000 Heavy Duty'],
                                'umpan' => ['Ayu Natural (15g)', 'Firetiger Glow (18g)', 'Red Head Pearl (20g)', 'Silver Sardine (22g)'],
                                'senar' => ['PE 0.8 / 15 lbs (150m)', 'PE 1.2 / 22 lbs (200m)', 'PE 2.0 / 35 lbs (300m)', 'PE 3.0 / 48 lbs (300m)'],
                                'kail-aksesori' => ['Size #1/0 (Isi 10)', 'Size #2/0 (Isi 8)', 'Size #3/0 (Isi 6)', 'Size #4/0 (Isi 5)'],
                                default => ['Standar Original', 'Turnamen Edition'],
                            };
                            if (!empty($item['variant']) && !in_array($item['variant'], $variantOptions)) {
                                array_unshift($variantOptions, $item['variant']);
                            }
                            $isSelected = $item['selected'] ?? true;
                        @endphp

                        <div 
                            id="cart-row-{{ $item['id'] }}"
                            class="p-4 sm:p-5 rounded-2xl bg-white border transition-all shadow-xs flex flex-col sm:flex-row sm:items-center gap-4 {{ $isSelected ? 'border-emerald-500/50 ring-1 ring-emerald-500/10' : 'border-slate-200 opacity-75' }}"
                        >
                            {{-- Checkbox & Image --}}
                            <div class="flex items-center gap-3.5">
                                <input 
                                    type="checkbox" 
                                    class="cart-item-checkbox w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer shrink-0"
                                    data-product-id="{{ $item['id'] }}"
                                    {{ $isSelected ? 'checked' : '' }}
                                    onchange="toggleCartItemSelect({{ $item['id'] }}, this.checked)"
                                    aria-label="Pilih {{ $item['name'] }}"
                                />
                                <a href="{{ route('catalog.show', $item['slug']) }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if (!empty($item['image']))
                                        <img 
                                            src="{{ $item['image'] }}" 
                                            alt="{{ $item['name'] }}" 
                                            class="w-full h-full object-cover hover:scale-105 transition-transform"
                                        />
                                    @else
                                        <span class="text-[10px] text-slate-400 text-center px-2">Belum ada foto</span>
                                    @endif
                                </a>
                            </div>

                            {{-- Product Details & Variant Picker --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 text-[11px] text-slate-500 mb-1">
                                    <span class="font-bold text-emerald-700 uppercase tracking-wider">{{ $item['category'] }}</span>
                                    <span>•</span>
                                    <span class="font-mono text-slate-400">SKU: {{ $item['sku'] ?: '-' }}</span>
                                </div>

                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-900 hover:text-emerald-700 transition-colors leading-snug">
                                    <a href="{{ route('catalog.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                </h3>

                                {{-- Simple Inline Variant Selector --}}
                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <label for="variant-select-{{ $item['id'] }}" class="text-[11px] font-semibold text-slate-500">Varian:</label>
                                    <select 
                                        id="variant-select-{{ $item['id'] }}"
                                        onchange="changeCartItemVariant({{ $item['id'] }}, this.value)"
                                        class="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 text-slate-800 focus:outline-none focus:border-emerald-500 cursor-pointer"
                                    >
                                        @foreach ($variantOptions as $opt)
                                            <option value="{{ $opt }}" {{ ($item['variant'] ?? '') === $opt ? 'selected' : '' }}>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Unit Price --}}
                                <div class="mt-2 flex items-baseline gap-2">
                                    <span class="text-sm font-bold text-slate-800">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </span>
                                    @if (($item['original_price'] ?? 0) > $item['price'])
                                        <span class="text-xs text-slate-400 line-through">
                                            Rp {{ number_format($item['original_price'], 0, ',', '.') }}
                                        </span>
                                    @endif
                                    <span class="text-[11px] text-slate-400">/ unit</span>
                                </div>
                            </div>

                            {{-- Quantity Stepper & Subtotal --}}
                            <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                <div class="text-left sm:text-right">
                                    <span class="text-[11px] text-slate-400 block">Subtotal Produk</span>
                                    <span class="font-heading font-extrabold text-base sm:text-lg text-emerald-900" id="item-subtotal-{{ $item['id'] }}">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    {{-- Stepper --}}
                                    <div class="inline-flex items-center border border-slate-300 rounded-xl bg-slate-50 overflow-hidden">
                                        <button 
                                            type="button"
                                            onclick="changeCartPageQty({{ $item['id'] }}, -1, {{ $item['max_stock'] }})"
                                            class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 font-bold text-slate-700 transition-colors cursor-pointer"
                                            aria-label="Kurangi jumlah"
                                        >
                                            −
                                        </button>
                                        <input 
                                            type="number" 
                                            id="qty-input-{{ $item['id'] }}"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            max="{{ $item['max_stock'] }}"
                                            onchange="setCartPageQty({{ $item['id'] }}, this.value, {{ $item['max_stock'] }})"
                                            class="w-10 text-center font-heading font-bold text-xs bg-white py-1.5 border-x border-slate-200 focus:outline-none text-slate-900"
                                        />
                                        <button 
                                            type="button"
                                            onclick="changeCartPageQty({{ $item['id'] }}, 1, {{ $item['max_stock'] }})"
                                            class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 font-bold text-slate-700 transition-colors cursor-pointer"
                                            aria-label="Tambah jumlah"
                                        >
                                            +
                                        </button>
                                    </div>

                                    {{-- Remove Item Button --}}
                                    <button 
                                        type="button"
                                        onclick="removeCartPageItem({{ $item['id'] }})"
                                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                        title="Hapus produk ini"
                                        aria-label="Hapus {{ $item['name'] }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT COLUMN: STICKY ORDER SUMMARY (1 col) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm sticky top-28 space-y-5">
                    <div class="pb-4 border-b border-slate-100">
                        <h2 class="font-heading font-extrabold text-lg text-slate-900">Ringkasan Belanja</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Periksa kembali produk yang Anda pilih sebelum checkout</p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Produk Dipilih</span>
                            <span class="font-bold text-slate-900"><span id="summarySelectedCount">{{ $summary['selected_items'] }}</span> item</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Estimasi Berat Paket</span>
                            <span class="font-semibold text-slate-800"><span id="summaryWeight">{{ number_format($summary['total_weight'], 0, ',', '.') }}</span> gram</span>
                        </div>
                        @if ($summary['total_savings'] > 0)
                            <div class="flex items-center justify-between text-emerald-700 font-medium">
                                <span>Total Hemat Diskon</span>
                                <span id="summarySavings">-{{ $summary['formatted_savings'] }}</span>
                            </div>
                        @endif
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="font-bold text-slate-900">Total Harga Produk</span>
                            <span class="font-heading font-extrabold text-2xl text-emerald-900" id="summarySubtotal">
                                {{ $summary['formatted_subtotal'] }}
                            </span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 space-y-1.5">
                        <div class="flex items-center gap-2 font-semibold text-slate-800">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Garansi Aman Sampai Tujuan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Joran dikirim menggunakan pipa PVC tebal. Pilihan ekspedisi & metode pembayaran dapat diatur pada langkah berikutnya.
                        </p>
                    </div>

                    @guest
                        <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-800 space-y-1">
                            <div class="font-bold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Wajib Login untuk Checkout</span>
                            </div>
                            <p class="text-[11px] text-amber-700 leading-relaxed">
                                Silakan masuk atau daftar akun terlebih dahulu sebelum mengisi data pemesanan.
                            </p>
                        </div>
                    @endguest

                    <div class="space-y-2.5">
                        <a 
                            href="{{ route('checkout.index') }}"
                            id="proceedCheckoutLink"
                            class="w-full py-4 px-5 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 transition-all flex items-center justify-center gap-2 {{ $summary['selected_items'] <= 0 ? 'opacity-50 pointer-events-none' : '' }}"
                        >
                            <span>{{ Auth::check() ? 'Lanjut ke Data Pemesanan' : 'Login / Daftar untuk Checkout' }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <a 
                            href="{{ route('catalog.index') }}" 
                            class="block w-full py-2.5 text-center text-xs font-semibold text-slate-600 hover:text-emerald-800 transition-colors"
                        >
                            ← Tambah Produk Lain dari Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart State --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-10 sm:p-14 text-center max-w-2xl mx-auto shadow-xs">
            <div class="w-20 h-20 rounded-3xl bg-emerald-50 border border-emerald-100 text-emerald-700 mx-auto flex items-center justify-center mb-5">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900">Keranjang Belanja Masih Kosong</h2>
            <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">
                Anda belum memilih perlengkapan memancing. Pilih produk di bawah ini atau jelajahi katalog lengkap kami.
            </p>
            <div class="mt-6 flex items-center justify-center gap-3 flex-wrap">
                <a href="{{ route('catalog.index') }}" class="px-6 py-3 rounded-xl bg-[#064E3B] hover:bg-emerald-700 text-white font-heading font-bold text-xs shadow-md transition-all">
                    Jelajahi Katalog Produk
                </a>
                <a href="#pilih-produk-cepat" class="px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-heading font-bold text-xs transition-all">
                    Pilih Cepat di Bawah ↓
                </a>
            </div>
        </div>
    @endif

    {{-- QUICK PRODUCT SELECTOR SECTION --}}
    @if ($quickProducts->count() > 0)
        <div id="pilih-produk-cepat" class="mt-14 pt-10 border-t border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Pilih & Tambah Langsung</span>
                    <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 mt-0.5">
                        Rekomendasi Perlengkapan Pancing Siap Kirim
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">Klik tombol <strong>+ Pilih Produk</strong> untuk langsung memasukkan ke keranjang belanja Anda.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1 self-start sm:self-auto">
                    <span>Lihat Semua Katalog</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($quickProducts as $product)
                    @php
                        $effectivePrice = $product->discount_price ?? $product->price;
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-emerald-500/40 transition-all">
                        <div>
                            <div class="relative aspect-[4/3] rounded-xl bg-slate-50 border border-slate-100 overflow-hidden mb-3 flex items-center justify-center">
                                @if ($product->image_url)
                                    <img 
                                        src="{{ $product->image_url }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-full object-cover"
                                    />
                                @else
                                    <span class="text-[11px] text-slate-400">Belum ada foto</span>
                                @endif
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/80 text-white text-[10px] font-bold">
                                    {{ $product->category?->name ?? 'Gear' }}
                                </span>
                            </div>
                            <h3 class="font-heading font-bold text-sm text-slate-900 line-clamp-2 leading-snug">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-emerald-700">{{ $product->name }}</a>
                            </h3>
                        </div>

                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <div>
                                <span class="font-heading font-extrabold text-sm text-emerald-900 block">
                                    Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-slate-400">Stok: {{ $product->stock }}</span>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button 
                                    type="submit" 
                                    class="px-3 py-2 rounded-xl bg-[#064E3B] hover:bg-emerald-600 text-white text-xs font-bold transition-all flex items-center gap-1 shadow-xs cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>Pilih</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function updateCartSummaryDOM(summary) {
        if (!summary) return;
        const selectedCountEl = document.getElementById('summarySelectedCount');
        const weightEl = document.getElementById('summaryWeight');
        const subtotalEl = document.getElementById('summarySubtotal');
        const badgeEl = document.getElementById('cartCountBadge');
        const checkoutBtn = document.getElementById('proceedCheckoutLink');
        const shippingBar = document.getElementById('cartPageShippingBar');
        const shippingText = document.getElementById('cartPageShippingText');

        if (selectedCountEl) selectedCountEl.textContent = summary.selected_items;
        if (weightEl) weightEl.textContent = summary.total_weight.toLocaleString('id-ID');
        if (subtotalEl) subtotalEl.textContent = summary.formatted_subtotal;
        if (badgeEl) badgeEl.textContent = summary.total_items;

        if (checkoutBtn) {
            if (summary.selected_items <= 0) {
                checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
            } else {
                checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
            }
        }

        if (shippingBar) {
            shippingBar.style.width = `${summary.shipping_progress}%`;
        }
        if (shippingText) {
            if (summary.is_free_shipping) {
                shippingText.innerHTML = `<span class="font-bold text-emerald-800">🎉 Selamat! Pesanan Anda mendapat Gratis Ongkir!</span>`;
            } else {
                shippingText.innerHTML = `Tambah belanja <strong class="font-extrabold text-emerald-800">Rp ${summary.remaining_free_shipping.toLocaleString('id-ID')}</strong> lagi untuk klaim <strong>Gratis Ongkir</strong>!`;
            }
        }
    }

    function toggleCartItemSelect(productId, isSelected) {
        const row = document.getElementById(`cart-row-${productId}`);
        if (row) {
            if (isSelected) {
                row.classList.add('border-emerald-500/50', 'ring-1', 'ring-emerald-500/10');
                row.classList.remove('border-slate-200', 'opacity-75');
            } else {
                row.classList.remove('border-emerald-500/50', 'ring-1', 'ring-emerald-500/10');
                row.classList.add('border-slate-200', 'opacity-75');
            }
        }

        const allBoxes = Array.from(document.querySelectorAll('.cart-item-checkbox'));
        const selectAllBox = document.getElementById('selectAllCartCheckbox');
        if (selectAllBox) {
            selectAllBox.checked = allBoxes.length > 0 && allBoxes.every(cb => cb.checked);
        }

        fetch('{{ route("cart.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, selected: isSelected })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartSummaryDOM(data.summary);
            }
        });
    }

    function toggleSelectAllCart(selectAll) {
        document.querySelectorAll('.cart-item-checkbox').forEach(cb => {
            cb.checked = selectAll;
            const pid = cb.getAttribute('data-product-id');
            const row = document.getElementById(`cart-row-${pid}`);
            if (row) {
                if (selectAll) {
                    row.classList.add('border-emerald-500/50', 'ring-1', 'ring-emerald-500/10');
                    row.classList.remove('border-slate-200', 'opacity-75');
                } else {
                    row.classList.remove('border-emerald-500/50', 'ring-1', 'ring-emerald-500/10');
                    row.classList.add('border-slate-200', 'opacity-75');
                }
            }
        });

        fetch('{{ route("cart.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ select_all: selectAll })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartSummaryDOM(data.summary);
            }
        });
    }

    function changeCartPageQty(productId, delta, maxStock) {
        const input = document.getElementById(`qty-input-${productId}`);
        if (!input) return;
        let next = (parseInt(input.value) || 1) + delta;
        if (next <= 0) {
            removeCartPageItem(productId);
            return;
        }
        if (next > maxStock) {
            showToast('Batas Stok', `Stok maksimal produk ini adalah ${maxStock} unit.`);
            next = maxStock;
        }
        input.value = next;
        setCartPageQty(productId, next, maxStock);
    }

    function setCartPageQty(productId, qtyVal, maxStock) {
        let qty = parseInt(qtyVal) || 1;
        if (qty < 1) qty = 1;
        if (qty > maxStock) qty = maxStock;

        const input = document.getElementById(`qty-input-${productId}`);
        if (input) input.value = qty;

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast('Peringatan', data.message || 'Gagal memperbarui jumlah.');
            }
        });
    }

    function changeCartItemVariant(productId, newVariant) {
        const input = document.getElementById(`qty-input-${productId}`);
        const qty = input ? (parseInt(input.value) || 1) : 1;

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, quantity: qty, variant: newVariant })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Varian Diperbarui', `Varian diubah menjadi: ${newVariant}`);
            }
        });
    }

    function removeCartPageItem(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
@endsection

