@props(['category'])

<a 
    href="{{ route('catalog.category', $category->slug) }}" 
    class="group flex flex-col justify-between p-5 rounded-[18px] bg-white border border-[#E8EDF1] hover:border-[#194668]/40 product-card-hover"
>
    @if ($category->image_url)
        <div class="w-full aspect-[16/10] rounded-[14px] overflow-hidden bg-[#F5F7F9] border border-[#E8EDF1] mb-4">
            <img 
                src="{{ $category->image_url }}" 
                alt="{{ $category->name }}" 
                loading="lazy"
                class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500 ease-out"
            />
        </div>
    @endif

    <div>
        <div class="flex items-center justify-between gap-2 mb-3">
            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#F5F7F9] text-[#194668] border border-[#DCE5EB]">
                {{ $category->products_count ?? $category->products->count() }} Produk
            </span>
            <span class="w-7 h-7 rounded-full bg-[#F5F7F9] group-hover:bg-[#194668] text-[#7A8791] group-hover:text-white flex items-center justify-center transition-colors">
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </div>

        <h3 class="font-heading text-base font-bold text-[#202B35] group-hover:text-[#194668] transition-colors">
            {{ $category->name }}
        </h3>

        <p class="text-xs font-sans font-normal text-[#7A8791] mt-1.5 line-clamp-2 leading-relaxed">
            {{ $category->description }}
        </p>
    </div>
</a>
