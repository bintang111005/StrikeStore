@props(['product'])

@php
    $effectivePrice = $product->discount_price ?? $product->price;
    $hasDiscount = !empty($product->discount_price) && $product->discount_price < $product->price;
    $discountPercent = $product->discount_percentage;
    $isOutOfStock = $product->status === 'out_of_stock' || $product->stock <= 0;
@endphp

<div class="group flex flex-col h-full bg-white rounded-2xl border border-slate-200 hover:border-emerald-500/60 shadow-xs hover:shadow-md overflow-hidden transition-all">
    {{-- Card Media / Image Container --}}
    <a href="{{ route('catalog.show', $product->slug) }}" class="relative w-full aspect-[4/3] bg-slate-50 border-b border-slate-100 overflow-hidden flex items-center justify-center">
        @if ($product->image_url)
            <img 
                src="{{ $product->image_url }}" 
                alt="{{ $product->name }}" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
        @else
            <div class="flex flex-col items-center justify-center text-slate-300 p-4 text-center select-none">
                <svg class="w-10 h-10 mb-1.5 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-[11px] font-medium text-slate-400">Belum ada foto</span>
            </div>
        @endif

        {{-- Badges (Top Left) --}}
        <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1 z-10 pointer-events-none">
            @if ($hasDiscount)
                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-rose-600 text-white">
                    -{{ $discountPercent }}%
                </span>
            @endif
            @if ($product->is_featured)
                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-500 text-white">
                    Unggulan
                </span>
            @endif
        </div>

        {{-- Stock Badge (Top Right) --}}
        @if ($isOutOfStock)
            <div class="absolute top-2.5 right-2.5 z-10 pointer-events-none">
                <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-800 text-white">
                    Habis
                </span>
            </div>
        @endif
    </a>

    {{-- Card Body --}}
    <div class="p-4 flex flex-col flex-grow justify-between gap-3">
        <div>
            <div class="flex items-center justify-between gap-2 text-[11px] mb-1">
                <span class="font-semibold text-emerald-700 truncate">
                    {{ $product->category?->name ?? 'Peralatan Pancing' }}
                </span>
                <span class="text-slate-400 shrink-0" title="Total dilihat">
                    {{ $product->views_count ?? 0 }}x dilihat
                </span>
            </div>

            <h3 class="font-heading font-bold text-sm text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">
                <a href="{{ route('catalog.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        {{-- Price & Add to Cart --}}
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
            <div>
                <div class="text-base font-bold font-heading text-slate-900">
                    Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                </div>
                @if ($hasDiscount)
                    <div class="text-[11px] text-slate-400 line-through">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                @else
                    <div class="text-[11px] text-slate-400">
                        Stok: {{ $product->stock }}
                    </div>
                @endif
            </div>

            @if ($isOutOfStock)
                <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold">
                    Habis
                </span>
            @else
                <button 
                    type="button"
                    onclick="addToCart({{ $product->id }}, 1, this)"
                    class="px-3.5 py-2 rounded-xl bg-[#064E3B] hover:bg-emerald-700 text-white text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer shrink-0"
                    title="Tambah ke Keranjang"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Keranjang</span>
                </button>
            @endif
        </div>
    </div>
</div>
