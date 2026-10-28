@props(['product'])

@php
    $effectivePrice = $product->discount_price ?? $product->price;
    $hasDiscount = !empty($product->discount_price) && $product->discount_price < $product->price;
    $discountPercent = $product->discount_percentage;
    $isOutOfStock = $product->status === 'out_of_stock' || $product->stock <= 0;
@endphp

<div class="group relative flex flex-col h-full bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/40 product-card-hover overflow-hidden transition-all duration-300">
    {{-- Card Media / Image Container --}}
    <div class="relative w-full aspect-[4/3] bg-gradient-to-b from-slate-100 to-slate-50 overflow-hidden flex items-center justify-center p-4">
        {{-- Product Image --}}
        <a href="{{ route('catalog.show', $product->slug) }}" class="w-full h-full flex items-center justify-center">
            <img 
                src="{{ $product->image_url }}" 
                alt="{{ $product->name }}" 
                loading="lazy"
                class="w-full h-full object-cover rounded-xl transition-transform duration-500 group-hover:scale-105"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=600&q=80';"
            />
        </a>

        {{-- Badges Container (Top Left) --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
            @if ($hasDiscount)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-600 text-white shadow-sm shadow-rose-900/30">
                    -{{ $discountPercent }}%
                </span>
            @endif

            @if ($product->is_featured)
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-sm shadow-amber-900/20">
                    <svg class="w-3 h-3 fill-current text-white" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Top Pick
                </span>
            @endif
        </div>

        {{-- Stock Badge (Top Right) --}}
        <div class="absolute top-3 right-3 z-10 pointer-events-none">
            @if ($isOutOfStock)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-900/80 backdrop-blur-sm text-slate-200">
                    Stok Habis
                </span>
            @elseif ($product->stock <= 5)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/90 text-white shadow-xs">
                    Sisa {{ $product->stock }}
                </span>
            @endif
        </div>

        {{-- Quick view overlay button --}}
        <div class="absolute inset-x-3 bottom-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden sm:flex justify-center z-10">
            <a href="{{ route('catalog.show', $product->slug) }}" class="w-full py-2 px-3 text-center text-xs font-semibold rounded-lg bg-slate-900/90 backdrop-blur-md text-white hover:bg-emerald-700 transition-colors shadow-lg">
                Lihat Detail Spesifikasi
            </a>
        </div>
    </div>

    {{-- Card Details --}}
    <div class="p-4 sm:p-5 flex flex-col flex-grow justify-between">
        <div>
            {{-- Category & Brand --}}
            <div class="flex items-center justify-between gap-2 text-xs text-slate-500 mb-1.5">
                <span class="font-medium text-emerald-700 uppercase tracking-wider text-[11px]">
                    {{ $product->category?->name ?? 'Fishing Gear' }}
                </span>
                <span class="font-semibold text-slate-600 truncate max-w-[100px]">
                    {{ $product->brand }}
                </span>
            </div>

            {{-- Title --}}
            <h3 class="font-heading font-semibold text-sm sm:text-base text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors mb-2">
                <a href="{{ route('catalog.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>

            {{-- Rating & Reviews --}}
            <div class="flex items-center gap-1.5 mb-3">
                <div class="flex items-center text-amber-400 text-xs">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-700">{{ $product->rating_score }}</span>
                <span class="text-[11px] text-slate-400">({{ $product->review_count }})</span>
            </div>
        </div>

        {{-- Price & Add to Cart Action --}}
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
            <div>
                <div class="flex items-baseline gap-1.5 flex-wrap">
                    <span class="text-base sm:text-lg font-bold font-heading text-emerald-900">
                        Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                    </span>
                    @if ($hasDiscount)
                        <span class="text-xs text-slate-400 line-through">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    @endif
                </div>
                <span class="text-[10px] text-slate-400 block mt-0.5">
                    @if(!$isOutOfStock)
                        Ready stock: {{ $product->stock }} unit
                    @else
                        Stok sementara kosong
                    @endif
                </span>
            </div>

            {{-- Cart Button --}}
            <div>
                @if ($isOutOfStock)
                    <button 
                        type="button" 
                        disabled 
                        class="p-2.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed border border-slate-200"
                        title="Stok Habis"
                        aria-label="Stok Habis"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </button>
                @else
                    <button 
                        type="button"
                        onclick="addToCart({{ $product->id }}, 1, this)"
                        class="relative p-2.5 rounded-xl bg-[#064E3B] text-white hover:bg-emerald-600 active:scale-95 transition-all shadow-md shadow-emerald-950/20 hover:shadow-emerald-500/25 border border-emerald-500/30 flex items-center justify-center group/btn cursor-pointer"
                        title="Tambah ke Keranjang"
                        aria-label="Tambah {{ $product->name }} ke keranjang"
                    >
                        <svg class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
