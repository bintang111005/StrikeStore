@props(['category'])

<a 
    href="{{ route('catalog.category', $category->slug) }}" 
    class="group flex flex-col justify-between p-5 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 shadow-xs hover:shadow-md transition-all"
>
    @if ($category->image_url)
        <div class="w-full aspect-[16/10] rounded-xl overflow-hidden bg-slate-50 border border-slate-100 mb-4">
            <img 
                src="{{ $category->image_url }}" 
                alt="{{ $category->name }}" 
                loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
        </div>
    @endif

    <div>
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                {{ $category->products_count ?? $category->products->count() }} Produk
            </span>
            <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>

        <h3 class="font-heading text-base sm:text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            {{ $category->name }}
        </h3>

        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
            {{ $category->description }}
        </p>
    </div>
</a>
