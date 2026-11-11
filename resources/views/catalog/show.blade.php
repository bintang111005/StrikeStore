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
<div class="bg-[#F5F7F9] border-b border-[#E8EDF1] py-3.5">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-[#7A8791] overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#194668]">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-[#194668]">Katalog</a>
            @if ($product->category)
                <span>/</span>
                <a href="{{ route('catalog.category', $product->category->slug) }}" class="hover:text-[#194668]">
                    {{ $product->category->name }}
                </a>
            @endif
            <span>/</span>
            <span class="text-[#202B35] font-semibold truncate max-w-xs">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="bg-white rounded-[20px] border border-[#E8EDF1] p-6 sm:p-10 shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            {{-- LEFT: PRODUCT PHOTO --}}
            <div class="lg:col-span-5">
                <div class="relative w-full aspect-square bg-[#F5F7F9] rounded-[18px] border border-[#E8EDF1] overflow-hidden flex items-center justify-center">
                    @if ($product->image_url)
                        <img 
                            id="mainProductImage"
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover"
                        />
                    @else
                        <div class="flex flex-col items-center justify-center text-[#7A8791] p-6 text-center select-none">
                            <svg class="w-16 h-16 mb-2 stroke-1 text-[#7A8791]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-medium text-[#7A8791]">Belum ada foto produk</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: PRODUCT INFO & ORDER CONTROLS --}}
            <div class="lg:col-span-7 space-y-5">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    @if ($product->category)
                        <a href="{{ route('catalog.category', $product->category->slug) }}" class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#F5F7F9] text-[#194668] border border-[#DCE5EB]">
                            {{ $product->category->name }}
                        </a>
                    @endif
                    <span class="text-xs font-mono text-[#7A8791]">SKU: {{ $product->sku ?? '-' }}</span>
                </div>

                <h1 class="font-heading font-bold text-2xl sm:text-3xl text-[#202B35] leading-snug">
                    {{ $product->name }}
                </h1>

                {{-- Price --}}
                <div class="p-4 rounded-[16px] bg-[#F5F7F9] border border-[#E8EDF1] flex items-baseline gap-3 flex-wrap">
                    <span class="font-sans font-bold text-2xl sm:text-3xl text-[#194668]">
                        Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                    </span>
                    @if ($hasDiscount)
                        <span class="text-sm text-[#7A8791] line-through">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-[#C5804B]/15 text-[#C5804B]">
                            Hemat {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                @if ($product->description)
                    <div class="text-sm font-sans text-[#7A8791] leading-relaxed">
                        <p class="whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                @endif

                {{-- Variant Selector --}}
                <div class="space-y-2.5 pt-3 border-t border-[#E8EDF1]">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-[#202B35] uppercase">Pilih Varian:</span>
                        <span id="activeVariantDisplay" class="font-semibold text-[#194668]">{{ $variants[0] }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5">
                        @foreach ($variants as $idx => $v)
                            <button 
                                type="button" 
                                onclick="selectVariant('{{ $v }}', this)"
                                class="variant-btn px-3.5 py-2.5 rounded-xl border text-xs font-semibold text-left transition-all cursor-pointer {{ $idx === 0 ? 'border-[#194668] bg-[#F5F7F9] text-[#194668]' : 'border-[#E8EDF1] bg-white text-[#202B35] hover:border-[#DCE5EB]' }}"
                            >
                                {{ $v }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedVariantInput" value="{{ $variants[0] }}">
                </div>

                {{-- Quantity & Actions --}}
                <div class="pt-3 border-t border-[#E8EDF1] space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-[#202B35] uppercase">Jumlah:</span>
                            <div class="inline-flex items-center border border-[#E8EDF1] rounded-xl bg-white overflow-hidden">
                                <button type="button" onclick="adjustDetailQty(-1)" class="px-3.5 py-1.5 hover:bg-[#F5F7F9] font-bold text-[#202B35] cursor-pointer">−</button>
                                <input 
                                    type="number" 
                                    id="detailQtyInput" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $product->stock }}"
                                    onchange="validateDetailQty(this)"
                                    class="w-12 text-center font-bold text-xs border-x border-[#E8EDF1] py-1.5 focus:outline-none text-[#202B35]"
                                />
                                <button type="button" onclick="adjustDetailQty(1)" class="px-3.5 py-1.5 hover:bg-[#F5F7F9] font-bold text-[#202B35] cursor-pointer">+</button>
                            </div>
                        </div>
                        <span class="text-xs font-semibold {{ $isOutOfStock ? 'text-rose-600' : 'text-[#7A8791]' }}">
                            {{ $isOutOfStock ? 'Stok Habis' : 'Stok tersedia: ' . $product->stock . ' unit' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @if ($isOutOfStock)
                            <button type="button" disabled class="sm:col-span-2 py-3.5 px-6 rounded-xl bg-[#F5F7F9] text-[#7A8791] font-semibold text-sm cursor-not-allowed">
                                Stok Habis
                            </button>
                        @else
                            <button 
                                type="button"
                                id="detailAddToCartBtn"
                                onclick="handleDetailAddToCart()"
                                class="py-3.5 px-5 rounded-xl font-sans font-semibold text-sm bg-[#194668] hover:bg-[#102D42] text-white transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs"
                            >
                                <span>+ Tambah ke Keranjang</span>
                            </button>
                            <button 
                                type="button"
                                onclick="handleDetailBuyNow()"
                                class="py-3.5 px-5 rounded-xl font-sans font-semibold text-sm bg-[#C5804B] hover:bg-[#b06f3c] text-white transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs"
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
            <h2 class="font-heading font-bold text-xl text-[#202B35] mb-6">Produk Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
            b.classList.remove('border-[#194668]', 'bg-[#F5F7F9]', 'text-[#194668]');
            b.classList.add('border-[#E8EDF1]', 'bg-white', 'text-[#202B35]');
        });

        btn.classList.remove('border-[#E8EDF1]', 'bg-white', 'text-[#202B35]');
        btn.classList.add('border-[#194668]', 'bg-[#F5F7F9]', 'text-[#194668]');
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
