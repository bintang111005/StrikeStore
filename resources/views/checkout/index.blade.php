@extends('layouts.app')

@section('title', 'Checkout & Data Pemesanan — StrikeStore')
@section('meta_description', 'Lengkapi data pemesanan dan pengiriman perlengkapan memancing Anda di StrikeStore dengan mudah, cepat, dan aman.')

@section('content')
{{-- Top Step Progress Header --}}
<div class="bg-white border-b border-slate-200/80 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('cart.page') }}" class="hover:text-emerald-700 transition-colors">Keranjang Belanja</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Checkout Pemesanan</span>
                </nav>
                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Isi Data Pemesanan
                </h1>
            </div>

            {{-- Simple 3-Step Indicator --}}
            <div class="flex items-center gap-2 sm:gap-3 text-xs font-semibold">
                <a href="{{ route('cart.page') }}" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[11px]">✓</span>
                    <span>Pilih Produk</span>
                </a>
                <svg class="w-4 h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#194668] text-white shadow-sm">
                    <span class="w-5 h-5 rounded-full bg-emerald-400 text-slate-950 font-extrabold flex items-center justify-center text-[11px]">2</span>
                    <span>Data Pemesanan</span>
                </div>
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
    {{-- Validation Errors Banner --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm">
            <div class="font-bold flex items-center gap-2 mb-1">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mohon periksa kembali data pemesanan Anda:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- QUICK PRODUCT PICKER MODAL / DRAWER TRIGGER BAR --}}
    <div class="mb-6 p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 font-bold">
                🎣
            </span>
            <div>
                <h2 class="font-heading font-bold text-sm text-slate-900">
                    @if (count($selectedItems) > 0)
                        {{ count($selectedItems) }} Jenis Produk ({{ $summary['selected_items'] }} unit) Siap Dipesan
                    @else
                        Belum Ada Produk yang Dipilih
                    @endif
                </h2>
                <p class="text-xs text-slate-500">
                    Ingin menambah joran, reel, umpan, atau senar sebelum menyelesaikan pesanan?
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button 
                type="button" 
                onclick="toggleQuickProductPicker()"
                class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Pilih / Tambah Produk</span>
            </button>
            <a 
                href="{{ route('cart.page') }}" 
                class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors"
            >
                Atur Keranjang
            </a>
        </div>
    </div>

    {{-- COLLAPSIBLE QUICK PRODUCT PICKER --}}
    <div id="quickProductPickerPanel" class="{{ count($selectedItems) === 0 ? '' : 'hidden' }} mb-8 p-5 sm:p-6 rounded-3xl bg-white border-2 border-emerald-500/30 shadow-md">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
            <div>
                <h3 class="font-heading font-extrabold text-base text-slate-900">Pilih Produk Perlengkapan Pancing</h3>
                <p class="text-xs text-slate-500">Klik tombol <strong>+ Pilih</strong> pada produk yang ingin Anda pesan.</p>
            </div>
            @if (count($selectedItems) > 0)
                <button type="button" onclick="toggleQuickProductPicker()" class="text-xs font-semibold text-slate-400 hover:text-slate-700 cursor-pointer">
                    Tutup ✕
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 max-h-96 overflow-y-auto pr-1 custom-scrollbar">
            @foreach ($availableProducts as $prod)
                @php
                    $effPrice = $prod->discount_price ?? $prod->price;
                    $inCart = collect($selectedItems)->firstWhere('id', $prod->id);
                @endphp
                <div class="p-3 rounded-2xl border {{ $inCart ? 'border-emerald-500 bg-emerald-50/30' : 'border-slate-200 bg-slate-50/60' }} flex items-center gap-3 justify-between">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-white border border-slate-200 shrink-0 flex items-center justify-center">
                        @if ($prod->image_url)
                            <img 
                                src="{{ $prod->image_url }}" 
                                alt="{{ $prod->name }}" 
                                class="w-full h-full object-cover"
                            />
                        @else
                            <span class="text-[9px] text-slate-400 text-center px-1">Tanpa Foto</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate" title="{{ $prod->name }}">{{ $prod->name }}</p>
                        <p class="text-[11px] text-emerald-800 font-extrabold mt-0.5">Rp {{ number_format($effPrice, 0, ',', '.') }}</p>
                        @if ($inCart)
                            <span class="inline-block text-[10px] font-bold text-emerald-700">✓ Di pesanan ({{ $inCart['quantity'] }}x)</span>
                        @else
                            <span class="inline-block text-[10px] text-slate-400">Stok: {{ $prod->stock }}</span>
                        @endif
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="shrink-0">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="redirect_checkout" value="1">
                        <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-[#194668] hover:bg-emerald-600 text-white text-[11px] font-bold transition-colors cursor-pointer">
                            + Pilih
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MAIN CHECKOUT FORM --}}
    <form action="{{ route('checkout.store') }}" method="POST" id="mainCheckoutForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- LEFT COLUMN: CUSTOMER DATA, SHIPPING & PAYMENT (2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- 1. DATA PENERIMA & ALAMAT PENGIRIMAN --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-sm space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-[#194668] text-white font-heading font-bold text-sm flex items-center justify-center">
                                1
                            </span>
                            <div>
                                <h2 class="font-heading font-extrabold text-base sm:text-lg text-slate-900">Data Pemesan & Alamat Pengiriman</h2>
                                <p class="text-xs text-slate-500">Username otomatis mengikuti akun Anda. Anda hanya perlu mengisi/mengubah No. HP dan Alamat.</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            ✓ Akun: {{ $user->name }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Username / Nama Pemesan (Otomatis & Tidak Bisa Diubah) --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="shipping_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Username / Nama Pemesan
                                </label>
                                <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    Otomatis
                                </span>
                            </div>
                            <input 
                                type="text" 
                                id="shipping_name"
                                name="shipping_name" 
                                value="{{ $user->name }}"
                                readonly
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm font-semibold text-slate-600 cursor-not-allowed focus:outline-none select-none"
                            />
                        </div>

                        {{-- Nomor WhatsApp (Bisa Diubah) --}}
                        <div>
                            <label for="shipping_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor HP / WhatsApp Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="shipping_phone"
                                name="shipping_phone" 
                                value="{{ old('shipping_phone', $user->phone ?? '') }}"
                                required 
                                placeholder="Contoh: 085263785531"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            />
                        </div>
                    </div>

                    {{-- Alamat Lengkap (Bisa Diubah) --}}
                    <div>
                        <label for="shipping_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Lengkap Pengiriman <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            id="shipping_address"
                            name="shipping_address" 
                            rows="3" 
                            required 
                            placeholder="Masukkan jalan, nomor rumah, RT/RW, kecamatan, kota/kabupaten, dan kode pos..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all"
                        >{{ old('shipping_address', $user->address ?? '') }}</textarea>
                    </div>

                    {{-- Catatan Pesanan (Opsional) --}}
                    <div>
                        <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Catatan Pesanan (Opsional)
                        </label>
                        <input 
                            type="text" 
                            id="notes"
                            name="notes" 
                            value="{{ old('notes') }}"
                            placeholder="Contoh: Packing pipa PVC tebal, kirim sore hari, dll."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all"
                        />
                    </div>
                </div>

                {{-- 2. METODE PENGIRIMAN / EKSPEDISI --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-xl bg-[#194668] text-white font-heading font-bold text-sm flex items-center justify-center">
                            2
                        </span>
                        <div>
                            <h2 class="font-heading font-extrabold text-base sm:text-lg text-slate-900">Pilih Kurir Pengiriman</h2>
                            <p class="text-xs text-slate-500">Gratis ongkir otomatis untuk ekspedisi bertanda khusus pada belanja min. Rp 500.000</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($shippingMethods as $key => $method)
                            @php
                                $baseCost = $method['cost'];
                                $effectiveCost = $baseCost;
                                if ($summary['is_free_shipping']) {
                                    $effectiveCost = $method['free_eligible'] ? 0 : max(0, $baseCost - 20000);
                                }
                                $isChecked = old('shipping_method', 'jnt_cargo_pvc') === $key;
                            @endphp
                            <label 
                                class="shipping-option-card relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between {{ $isChecked ? 'border-emerald-600 bg-emerald-50/40 ring-1 ring-emerald-500' : 'border-slate-200 hover:border-slate-300 bg-white' }}"
                            >
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex items-center gap-2.5">
                                            <input 
                                                type="radio" 
                                                name="shipping_method" 
                                                value="{{ $key }}"
                                                data-cost="{{ $effectiveCost }}"
                                                data-base-cost="{{ $baseCost }}"
                                                {{ $isChecked ? 'checked' : '' }}
                                                onchange="recalculateCheckoutTotals()"
                                                class="text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                            />
                                            <span class="font-heading font-bold text-xs sm:text-sm text-slate-900">{{ $method['name'] }}</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800 shrink-0">
                                            {{ $method['badge'] }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1.5 pl-6 leading-relaxed">
                                        {{ $method['description'] }}
                                    </p>
                                </div>

                                <div class="mt-3 pl-6 flex items-baseline gap-2">
                                    @if ($effectiveCost == 0)
                                        <span class="text-xs font-extrabold text-emerald-700">GRATIS</span>
                                        @if ($baseCost > 0)
                                            <span class="text-[11px] text-slate-400 line-through">Rp {{ number_format($baseCost, 0, ',', '.') }}</span>
                                        @endif
                                    @else
                                        <span class="text-xs font-extrabold text-slate-900">Rp {{ number_format($effectiveCost, 0, ',', '.') }}</span>
                                        @if ($effectiveCost < $baseCost)
                                            <span class="text-[11px] text-slate-400 line-through">Rp {{ number_format($baseCost, 0, ',', '.') }}</span>
                                        @endif
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- 3. METODE PEMBAYARAN --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-xl bg-[#194668] text-white font-heading font-bold text-sm flex items-center justify-center">
                            3
                        </span>
                        <div>
                            <h2 class="font-heading font-extrabold text-base sm:text-lg text-slate-900">Pilih Metode Pembayaran</h2>
                            <p class="text-xs text-slate-500">Semua transaksi dijamin aman & terverifikasi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($paymentMethods as $key => $pm)
                            @php
                                $isPmChecked = old('payment_method', 'bank_transfer') === $key;
                            @endphp
                            <label 
                                class="payment-option-card p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3 {{ $isPmChecked ? 'border-emerald-600 bg-emerald-50/40 ring-1 ring-emerald-500' : 'border-slate-200 hover:border-slate-300 bg-white' }}"
                            >
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="{{ $key }}"
                                    {{ $isPmChecked ? 'checked' : '' }}
                                    onchange="highlightPaymentCards()"
                                    class="mt-0.5 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                />
                                <div>
                                    <div class="font-heading font-bold text-xs sm:text-sm text-slate-900">{{ $pm['name'] }}</div>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $pm['description'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: STICKY PRODUCT SUMMARY & SUBMIT (1 col) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-sm sticky top-28 space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <h2 class="font-heading font-extrabold text-lg text-slate-900">Ringkasan Pesanan</h2>
                            <p class="text-xs text-slate-500">{{ count($selectedItems) }} produk ({{ $summary['selected_items'] }} item)</p>
                        </div>
                        <a href="{{ route('cart.page') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                            Ubah Produk
                        </a>
                    </div>

                    {{-- Selected Products List --}}
                    @if (count($selectedItems) > 0)
                        <div class="space-y-3 max-h-72 overflow-y-auto pr-1 custom-scrollbar">
                            @foreach ($selectedItems as $item)
                                <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200/70">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-white border border-slate-200 shrink-0 flex items-center justify-center">
                                        @if (!empty($item['image']))
                                            <img 
                                                src="{{ $item['image'] }}" 
                                                alt="{{ $item['name'] }}" 
                                                class="w-full h-full object-cover"
                                            />
                                        @else
                                            <span class="text-[9px] text-slate-400 text-center px-1">Tanpa Foto</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-bold text-slate-900 truncate">{{ $item['name'] }}</h4>
                                        @if (!empty($item['variant']))
                                            <span class="inline-block text-[10px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded mt-0.5">
                                                {{ $item['variant'] }}
                                            </span>
                                        @endif
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="text-[11px] text-slate-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                            <span class="text-xs font-extrabold text-emerald-900">
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                            <p class="text-xs font-bold text-amber-900">Belum ada produk yang dipilih</p>
                            <p class="text-[11px] text-amber-700 mt-1">Silakan pilih produk pada panel di atas atau kembali ke halaman keranjang.</p>
                        </div>
                    @endif

                    {{-- Promo / Voucher Code Input --}}
                    <div class="pt-2 border-t border-slate-100">
                        <label for="promo_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kode Promo / Voucher Angler
                        </label>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                id="promo_code"
                                name="promo_code" 
                                value="{{ old('promo_code') }}"
                                placeholder="Ketik kode promo..."
                                class="flex-1 px-3.5 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-bold uppercase text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                            <button 
                                type="button" 
                                onclick="applyPromoCode()"
                                class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-emerald-700 text-white text-xs font-bold transition-colors cursor-pointer"
                            >
                                Pakai
                            </button>
                        </div>
                        {{-- Quick Promo Chips --}}
                        <div class="flex items-center gap-1.5 flex-wrap mt-2">
                            <span class="text-[10px] text-slate-400">Voucher tersedia:</span>
                            <button type="button" onclick="selectPromoChip('STRIKE50')" class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-[10px] font-bold text-emerald-800 hover:bg-emerald-100 cursor-pointer">
                                STRIKE50 (Potongan 50rb)
                            </button>
                            <button type="button" onclick="selectPromoChip('HEMAT10')" class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-[10px] font-bold text-emerald-800 hover:bg-emerald-100 cursor-pointer">
                                HEMAT10 (Diskon 10%)
                            </button>
                        </div>
                        <p id="promoFeedbackMsg" class="text-[11px] font-semibold text-emerald-700 mt-1 hidden"></p>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="pt-4 border-t border-slate-100 space-y-2.5 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal Produk ({{ $summary['selected_items'] }} item)</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold text-slate-900" id="checkoutShippingDisplay">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-emerald-700 font-semibold hidden" id="checkoutDiscountRow">
                            <span>Potongan Voucher Promo</span>
                            <span id="checkoutDiscountDisplay">-Rp 0</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                            <span class="font-heading font-bold text-base text-slate-900">Total Pembayaran</span>
                            <span class="font-heading font-extrabold text-2xl text-emerald-900" id="checkoutGrandTotalDisplay">
                                Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Submit Order Button --}}
                    <button 
                        type="submit" 
                        {{ count($selectedItems) === 0 ? 'disabled' : '' }}
                        class="w-full py-4 px-6 rounded-xl font-heading font-bold text-sm bg-gradient-to-r from-[#194668] to-[#194668] hover:from-[#194668] hover:to-[#C5804B] text-white shadow-xl shadow-emerald-950/20 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:pointer-events-none"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Buat Pesanan Sekarang</span>
                    </button>

                    <p class="text-[11px] text-center text-slate-400 leading-relaxed">
                        Dengan menekan tombol di atas, pesanan Anda akan tercatat resmi dan Anda akan mendapatkan nomor invoice pemesanan.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
    const baseSubtotal = {{ (float) $summary['subtotal'] }};
    let currentDiscount = 0;

    function toggleQuickProductPicker() {
        const panel = document.getElementById('quickProductPickerPanel');
        panel.classList.toggle('hidden');
    }

    function appendNoteChip(text) {
        const input = document.getElementById('notes');
        if (!input.value) {
            input.value = text;
        } else if (!input.value.includes(text)) {
            input.value = input.value + ', ' + text;
        }
    }

    function selectPromoChip(code) {
        const input = document.getElementById('promo_code');
        input.value = code;
        applyPromoCode();
    }

    function applyPromoCode() {
        const code = (document.getElementById('promo_code').value || '').trim().toUpperCase();
        const msg = document.getElementById('promoFeedbackMsg');
        currentDiscount = 0;

        if (!code) {
            msg.classList.add('hidden');
            recalculateCheckoutTotals();
            return;
        }

        if (code === 'STRIKE50') {
            if (baseSubtotal >= 250000) {
                currentDiscount = 50000;
                msg.textContent = '✓ Voucher STRIKE50 aktif: Hemat Rp 50.000!';
                msg.className = 'text-[11px] font-semibold text-emerald-700 mt-1';
            } else {
                msg.textContent = 'Min. belanja Rp 250.000 untuk kode STRIKE50.';
                msg.className = 'text-[11px] font-semibold text-amber-700 mt-1';
            }
        } else if (code === 'HEMAT10') {
            currentDiscount = Math.min(100000, Math.round(baseSubtotal * 0.10));
            msg.textContent = `✓ Voucher HEMAT10 aktif: Hemat Rp ${currentDiscount.toLocaleString('id-ID')}!`;
            msg.className = 'text-[11px] font-semibold text-emerald-700 mt-1';
        } else if (code === 'ANGLER25') {
            currentDiscount = 25000;
            msg.textContent = '✓ Voucher ANGLER25 aktif: Hemat Rp 25.000!';
            msg.className = 'text-[11px] font-semibold text-emerald-700 mt-1';
        } else {
            msg.textContent = 'Kode voucher tidak ditemukan.';
            msg.className = 'text-[11px] font-semibold text-rose-600 mt-1';
        }

        currentDiscount = Math.min(currentDiscount, baseSubtotal);
        recalculateCheckoutTotals();
    }

    function recalculateCheckoutTotals() {
        // Update visual state of shipping cards
        document.querySelectorAll('.shipping-option-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                card.classList.add('border-emerald-600', 'bg-emerald-50/40', 'ring-1', 'ring-emerald-500');
                card.classList.remove('border-slate-200', 'bg-white');
            } else {
                card.classList.remove('border-emerald-600', 'bg-emerald-50/40', 'ring-1', 'ring-emerald-500');
                card.classList.add('border-slate-200', 'bg-white');
            }
        });

        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        const shippingCost = selectedShipping ? (parseFloat(selectedShipping.getAttribute('data-cost')) || 0) : 0;

        const shippingEl = document.getElementById('checkoutShippingDisplay');
        if (shippingEl) {
            shippingEl.textContent = shippingCost === 0 ? 'GRATIS (Rp 0)' : `Rp ${shippingCost.toLocaleString('id-ID')}`;
        }

        const discountRow = document.getElementById('checkoutDiscountRow');
        const discountEl = document.getElementById('checkoutDiscountDisplay');
        if (discountRow && discountEl) {
            if (currentDiscount > 0) {
                discountRow.classList.remove('hidden');
                discountEl.textContent = `-Rp ${currentDiscount.toLocaleString('id-ID')}`;
            } else {
                discountRow.classList.add('hidden');
            }
        }

        const grandTotal = Math.max(0, baseSubtotal + shippingCost - currentDiscount);
        const grandTotalEl = document.getElementById('checkoutGrandTotalDisplay');
        if (grandTotalEl) {
            grandTotalEl.textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
        }
    }

    function highlightPaymentCards() {
        document.querySelectorAll('.payment-option-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                card.classList.add('border-emerald-600', 'bg-emerald-50/40', 'ring-1', 'ring-emerald-500');
                card.classList.remove('border-slate-200', 'bg-white');
            } else {
                card.classList.remove('border-emerald-600', 'bg-emerald-50/40', 'ring-1', 'ring-emerald-500');
                card.classList.add('border-slate-200', 'bg-white');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        recalculateCheckoutTotals();
        if (document.getElementById('promo_code').value) {
            applyPromoCode();
        }
    });
</script>
@endpush
@endsection

