@extends('layouts.app')

@section('title', $product->name . ' — StrikeStore')
@section('meta_description', Str::limit(strip_tags($product->description), 160))

@section('content')
@php
    $effectivePrice = $product->discount_price ?? $product->price;
    $hasDiscount = !empty($product->discount_price) && $product->discount_price < $product->price;
    $isOutOfStock = $product->status === 'out_of_stock' || $product->stock <= 0;
    $catSlug = $product->category?->slug ?? '';

    $variants = match($catSlug) {
        'joran' => ['165cm / ML Action', '180cm / Medium Action', '198cm / MH Action', '210cm / Heavy Action'],
        'reel' => ['Size 2000 (Shallow Spool)', 'Size 2500 HG (High Gear)', 'Size 3000 CXH (Compact)', 'Size 4000 Power', 'Size 5000 Heavy Duty'],
        'umpan' => ['Ayu Natural (15g)', 'Firetiger Glow (18g)', 'Red Head Pearl (20g)', 'Silver Sardine (22g)'],
        'senar' => ['PE 0.8 / 15 lbs (150m)', 'PE 1.2 / 22 lbs (200m)', 'PE 2.0 / 35 lbs (300m)', 'PE 3.0 / 48 lbs (300m)'],
        'kail-aksesori' => ['Size #1/0 (Isi 10)', 'Size #2/0 (Isi 8)', 'Size #3/0 (Isi 6)', 'Size #4/0 (Isi 5)'],
        default => ['Standar Original', 'Turnamen Edition'],
    };
@endphp

{{-- Breadcrumb --}}
<div class="bg-white border-b border-slate-200 py-3.5">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-emerald-700">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-emerald-700">Katalog</a>
            @if ($product->category)
                <span>/</span>
                <a href="{{ route('catalog.category', $product->category->slug) }}" class="hover:text-emerald-700">
                    {{ $product->category->name }}
                </a>
            @endif
            <span>/</span>
            <span class="text-slate-900 font-semibold truncate max-w-xs">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT: PRODUCT PHOTO (Empty box if user hasn't uploaded a photo yet) --}}
            <div class="lg:col-span-5">
                <div class="relative w-full aspect-square bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden flex items-center justify-center">
                    @if ($product->image_url)
                        <img 
                            id="mainProductImage"
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover"
                        />
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-400 p-6 text-center select-none">
                            <svg class="w-16 h-16 mb-2 stroke-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-semibold text-slate-400">Belum ada foto produk</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: PRODUCT INFO & ORDER CONTROLS --}}
            <div class="lg:col-span-7 space-y-5">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    @if ($product->category)
                        <a href="{{ route('catalog.category', $product->category->slug) }}" class="px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            {{ $product->category->name }}
                        </a>
                    @endif
                    <span class="text-xs font-mono text-slate-400">SKU: {{ $product->sku ?? '-' }}</span>
                </div>

                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 leading-snug">
                    {{ $product->name }}
                </h1>

                {{-- Price --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-baseline gap-3 flex-wrap">
                    <span class="font-heading font-extrabold text-2xl sm:text-3xl text-emerald-900">
                        Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                    </span>
                    @if ($hasDiscount)
                        <span class="text-sm text-slate-400 line-through">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="px-2 py-0.5 rounded-md text-xs font-bold bg-rose-100 text-rose-700">
                            Hemat {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                @if ($product->description)
                    <div class="text-sm text-slate-600 leading-relaxed">
                        <p class="whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                @endif

                {{-- Variant Selector --}}
                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700 uppercase">Pilih Varian:</span>
                        <span id="activeVariantDisplay" class="font-bold text-emerald-700">{{ $variants[0] }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($variants as $idx => $v)
                            <button 
                                type="button" 
                                onclick="selectVariant('{{ $v }}', this)"
                                class="variant-btn px-3 py-2 rounded-xl border text-xs font-semibold text-left transition-all cursor-pointer {{ $idx === 0 ? 'border-emerald-600 bg-emerald-50 text-emerald-900' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300' }}"
                            >
                                {{ $v }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedVariantInput" value="{{ $variants[0] }}">
                </div>

                {{-- Quantity & Actions --}}
                <div class="pt-3 border-t border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-700 uppercase">Jumlah:</span>
                            <div class="inline-flex items-center border border-slate-300 rounded-xl bg-white overflow-hidden">
                                <button type="button" onclick="adjustDetailQty(-1)" class="px-3 py-1.5 hover:bg-slate-100 font-bold text-slate-700 cursor-pointer">−</button>
                                <input 
                                    type="number" 
                                    id="detailQtyInput" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $product->stock }}"
                                    onchange="validateDetailQty(this)"
                                    class="w-12 text-center font-bold text-xs border-x border-slate-200 py-1.5 focus:outline-none text-slate-900"
                                />
                                <button type="button" onclick="adjustDetailQty(1)" class="px-3 py-1.5 hover:bg-slate-100 font-bold text-slate-700 cursor-pointer">+</button>
                            </div>
                        </div>
                        <span class="text-xs font-semibold {{ $isOutOfStock ? 'text-rose-600' : 'text-slate-500' }}">
                            {{ $isOutOfStock ? 'Stok Habis' : 'Stok tersedia: ' . $product->stock . ' unit' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @if ($isOutOfStock)
                            <button type="button" disabled class="sm:col-span-2 py-3.5 px-6 rounded-xl bg-slate-200 text-slate-400 font-bold text-sm cursor-not-allowed">
                                Stok Habis
                            </button>
                        @else
                            <button 
                                type="button"
                                id="detailAddToCartBtn"
                                onclick="handleDetailAddToCart()"
                                class="py-3.5 px-5 rounded-xl font-heading font-bold text-sm bg-[#064E3B] hover:bg-emerald-700 text-white transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>+ Tambah ke Keranjang</span>
                            </button>
                            <button 
                                type="button"
                                onclick="handleDetailBuyNow()"
                                class="py-3.5 px-5 rounded-xl font-heading font-bold text-sm bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Beli & Checkout Sekarang</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Related Products --}}
    @if ($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="font-heading font-extrabold text-xl text-slate-900 mb-5">Produk Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    const maxProductStock = {{ $product->stock }};

    function selectVariant(variantName, btn) {
        document.getElementById('selectedVariantInput').value = variantName;
        document.getElementById('activeVariantDisplay').textContent = variantName;

        document.querySelectorAll('.variant-btn').forEach(b => {
            b.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-900');
            b.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
        });

        btn.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
        btn.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-900');
    }

    function adjustDetailQty(delta) {
        const input = document.getElementById('detailQtyInput');
        let next = (parseInt(input.value) || 1) + delta;
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

    function handleDetailAddToCart() {
        const qty = parseInt(document.getElementById('detailQtyInput').value) || 1;
        const variant = document.getElementById('selectedVariantInput').value;
        const btn = document.getElementById('detailAddToCartBtn');
        addToCart({{ $product->id }}, qty, btn, variant);
    }

    function handleDetailBuyNow() {
        const qty = parseInt(document.getElementById('detailQtyInput').value) || 1;
        const variant = document.getElementById('selectedVariantInput').value;
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: {{ $product->id }}, quantity: qty, variant: variant })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("checkout.index") }}';
            } else {
                showToast('Pemberitahuan', data.message || 'Gagal memproses produk.');
            }
        });
    }
</script>
@endpush
@endsection
