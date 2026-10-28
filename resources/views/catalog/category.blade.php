@extends('layouts.app')

@section('title', $category->name . ' — StrikeStore')
@section('meta_description', $category->description ?? 'Koleksi ' . $category->name . ' terbaik dan terlengkap di StrikeStore.')

@section('content')
{{-- CATEGORY HERO BANNER --}}
<section class="relative bg-gradient-to-br from-[#022C22] via-[#064E3B] to-[#071C17] text-white py-12 lg:py-16 overflow-hidden border-b border-emerald-900/60">
    {{-- Glow background --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_50%,rgba(16,185,129,0.2),transparent)] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-emerald-200/70 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-emerald-300 transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-emerald-300 transition-colors">Katalog</a>
            <span>/</span>
            <span class="text-white font-bold">{{ $category->name }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            <div class="md:col-span-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-950/80 text-emerald-300 border border-emerald-500/40 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Koleksi Spesialis Turnamen</span>
                </div>
                <h1 class="font-heading font-extrabold text-3xl sm:text-5xl text-white tracking-tight">
                    {{ $category->name }}
                </h1>
                <p class="text-emerald-100/80 text-sm sm:text-base mt-3 max-w-2xl leading-relaxed">
                    {{ $category->description }}
                </p>
                <div class="flex items-center gap-4 mt-6 text-xs text-emerald-200 flex-wrap">
                    <span class="flex items-center gap-1.5 bg-emerald-950/60 px-3 py-1.5 rounded-lg border border-emerald-800/60">
                        <strong class="text-white">{{ $products->total() }}</strong> Produk Tersedia
                    </span>
                    <span class="flex items-center gap-1.5 bg-emerald-950/60 px-3 py-1.5 rounded-lg border border-emerald-800/60">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Garansi 100% Produk Asli
                    </span>
                    <span class="flex items-center gap-1.5 bg-emerald-950/60 px-3 py-1.5 rounded-lg border border-emerald-800/60">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Kemasan Pipa PVC Aman
                    </span>
                </div>
            </div>

            {{-- Category Visual Vignette --}}
            <div class="hidden md:block md:col-span-4">
                <div class="relative rounded-3xl overflow-hidden aspect-[4/3] border border-emerald-500/30 shadow-2xl metallic-shine">
                    <img 
                        src="{{ $category->image_url }}" 
                        alt="{{ $category->name }}" 
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#022C22]/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 text-xs font-bold text-white uppercase tracking-wider bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-lg">
                        Premium {{ $category->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORY NAVIGATION PILLS --}}
<div class="bg-white border-b border-slate-200/80 sticky top-20 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 custom-scrollbar">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-2">Pilih Kategori:</span>
            <a 
                href="{{ route('catalog.index') }}" 
                class="px-3.5 py-1.5 rounded-xl text-xs font-semibold shrink-0 transition-colors bg-slate-100 hover:bg-slate-200 text-slate-700"
            >
                Semua Produk
            </a>
            @foreach ($allCategories as $cat)
                @php
                    $isCurrent = $cat->id === $category->id;
                @endphp
                <a 
                    href="{{ route('catalog.category', $cat->slug) }}" 
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold shrink-0 transition-all flex items-center gap-1.5 {{ $isCurrent ? 'bg-[#064E3B] text-white shadow-sm font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}"
                >
                    <span>{{ $cat->name }}</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $isCurrent ? 'bg-emerald-400 text-slate-950 font-bold' : 'bg-slate-200 text-slate-600' }}">
                        {{ $cat->products_count }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- PRODUCTS GRID & FILTER BAR --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Search & Sorting Toolbar --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xs">
        {{-- Search inside Category Form --}}
        <form action="{{ route('catalog.category', $category->slug) }}" method="GET" class="relative flex-1 max-w-md">
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if(request('availability'))
                <input type="hidden" name="availability" value="{{ request('availability') }}">
            @endif
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari dalam kategori {{ $category->name }}..." 
                class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:bg-white"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </form>

        {{-- Availability & Sorting --}}
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-1.5">
                <a 
                    href="{{ route('catalog.category', array_merge(['category' => $category->slug], request()->except('availability'))) }}" 
                    class="px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ !request('availability') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Semua
                </a>
                <a 
                    href="{{ route('catalog.category', array_merge(['category' => $category->slug, 'availability' => 'in_stock'], request()->except('availability'))) }}" 
                    class="px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('availability') === 'in_stock' ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Siap Kirim
                </a>
            </div>

            <div class="flex items-center gap-2">
                <label for="categorySort" class="text-xs text-slate-500 whitespace-nowrap">Urutkan:</label>
                <select 
                    id="categorySort"
                    onchange="const url = new URL(window.location.href); url.searchParams.set('sort', this.value); window.location.href = url.toString();"
                    class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 cursor-pointer"
                >
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Category Products Grid --}}
    @if ($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        {{-- Empty State with Clean SVG --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
            <h3 class="font-heading font-bold text-xl text-slate-900 mb-2">
                Belum ada produk untuk kategori ini
            </h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                @if(request('search'))
                    Tidak ditemukan produk dengan kata kunci "{{ request('search') }}" di kategori {{ $category->name }}.
                @else
                    Produk di kategori {{ $category->name }} sedang disiapkan oleh tim kurasi StrikeStore.
                @endif
            </p>
            <a 
                href="{{ route('catalog.index') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#064E3B] text-white font-bold text-xs hover:bg-emerald-700 transition-colors shadow-md"
            >
                <span>Lihat Semua Katalog</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    @endif
</div>
@endsection
