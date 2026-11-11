@props(['product'])

@php
    $effectivePrice = $product->discount_price ?? $product->price;
    $hasDiscount = !empty($product->discount_price) && $product->discount_price < $product->price;
    $discountPercent = $product->discount_percentage;
    $isOutOfStock = $product->status === 'out_of_stock' || $product->stock <= 0;
@endphp

<div class="group flex flex-col h-full bg-white rounded-[18px] border border-[#E8EDF1] hover:border-[#DCE5EB] p-3 product-card-hover">
    {{-- Card Media / Image Container --}}
    <a href="{{ route('catalog.show', $product->slug) }}" class="relative w-full aspect-[4/3] rounded-[14px] bg-[#F5F7F9] border border-[#E8EDF1]/60 overflow-hidden flex items-center justify-center">
        @if ($product->image_url)
            <img 
                src="{{ $product->image_url }}" 
                alt="{{ $product->name }}" 
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03]"
            />
        @else
            <div class="flex flex-col items-center justify-center text-[#7A8791] p-4 text-center select-none">
                <svg class="w-9 h-9 mb-1.5 stroke-[1.4] text-[#7A8791]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-[11px] font-medium text-[#7A8791]">Belum ada foto</span>
            </div>
        @endif

        {{-- Badges (Top Left) --}}
        <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5 z-10 pointer-events-none">
            @if ($hasDiscount)
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#102D42] text-white shadow-xs">
                    -{{ $discountPercent }}%
                </span>
            @endif
            @if ($product->is_featured)
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#C5804B] text-white shadow-xs">
                    Unggulan
                </span>
            @endif
        </div>

        {{-- Stock Badge (Top Right) --}}
        @if ($isOutOfStock)
            <div class="absolute top-2.5 right-2.5 z-10 pointer-events-none">
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#202B35]/90 text-white">
                    Habis
                </span>
            </div>
        @endif
    </a>

    {{-- Card Body --}}
    <div class="pt-3.5 px-1 pb-1 flex flex-col flex-grow justify-between gap-3">
        <div>
            <div class="flex items-center justify-between gap-2 text-[11px] mb-1.5">
                <span class="font-medium text-[#C5804B] truncate">
                    {{ $product->category?->name ?? 'Peralatan Pancing' }}
                </span>
                <span class="text-[#7A8791] flex items-center gap-1 shrink-0" title="Total dilihat">
                    <svg class="w-3.5 h-3.5 text-[#7A8791]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>{{ $product->views_count ?? 0 }}</span>
                </span>
            </div>

            <h3 class="font-heading font-semibold text-[15px] text-[#202B35] line-clamp-2 leading-snug group-hover:text-[#194668] transition-colors">
                <a href="{{ route('catalog.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        {{-- Price & Add to Cart --}}
        <div class="pt-3 border-t border-[#E8EDF1] flex items-center justify-between gap-2">
            <div>
                <div class="text-[15px] font-sans font-bold text-[#194668]">
                    Rp {{ number_format($effectivePrice, 0, ',', '.') }}
                </div>
                @if ($hasDiscount)
                    <div class="text-[11px] text-[#7A8791] line-through">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                @else
                    <div class="text-[11px] text-[#7A8791]">
                        Stok: {{ $product->stock }}
                    </div>
                @endif
            </div>

            @if ($isOutOfStock)
                <span class="px-3.5 py-2 rounded-xl bg-[#F5F7F9] text-[#7A8791] text-xs font-semibold">
                    Habis
                </span>
            @else
                <button 
                    type="button"
                    onclick="addToCart({{ $product->id }}, 1, this)"
                    class="px-3.5 py-2 rounded-xl bg-[#194668] hover:bg-[#102D42] text-white text-xs font-sans font-semibold transition-all duration-200 flex items-center gap-1.5 cursor-pointer shrink-0 shadow-xs"
                    title="Tambah ke Keranjang"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Keranjang</span>
                </button>
            @endif
        </div>
    </div>
</div>
