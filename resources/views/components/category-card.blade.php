@props(['category'])

<a 
    href="{{ route('catalog.category', $category->slug) }}" 
    class="group relative flex flex-col justify-end p-6 rounded-2xl overflow-hidden aspect-[4/5] sm:aspect-[3/4] bg-slate-900 border border-slate-700/50 shadow-md hover:shadow-2xl hover:border-emerald-500/50 transition-all duration-300 product-card-hover"
>
    {{-- Background Image with cinematic dark gradient --}}
    <img 
        src="{{ $category->image_url }}" 
        alt="{{ $category->name }}" 
        loading="lazy"
        class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-110 opacity-75 group-hover:opacity-85"
    />

    {{-- Dark Gradient Overlays for high contrast --}}
    <div class="absolute inset-0 bg-gradient-to-t from-[#022C22] via-[#064E3B]/60 to-transparent"></div>
    <div class="absolute inset-0 bg-radial from-transparent via-transparent to-black/40"></div>

    {{-- Category Content --}}
    <div class="relative z-10 flex flex-col">
        {{-- Item Count Tag --}}
        <div class="inline-flex items-center gap-1.5 self-start px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-950/80 backdrop-blur-md text-emerald-300 border border-emerald-500/30 mb-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>{{ $category->products_count ?? $category->products->count() }} Produk</span>
        </div>

        {{-- Category Name --}}
        <h3 class="font-heading text-xl sm:text-2xl font-bold text-white group-hover:text-emerald-300 transition-colors drop-shadow-sm flex items-center justify-between">
            <span>{{ $category->name }}</span>
            <svg class="w-5 h-5 text-emerald-400 transform translate-x-0 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </h3>

        {{-- Description --}}
        <p class="text-xs sm:text-sm text-slate-300 mt-1.5 line-clamp-2 leading-relaxed opacity-90">
            {{ $category->description }}
        </p>
    </div>
</a>
