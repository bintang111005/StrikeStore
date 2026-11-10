@extends('layouts.app')

@section('title', $category->name . ' — StrikeStore')
@section('meta_description', $category->description ?? 'Koleksi ' . $category->name . ' di StrikeStore.')

@section('content')
{{-- CLEAN & SIMPLE CATEGORY HEADER --}}
<div class="bg-white border-b border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-emerald-700 transition-colors">Katalog</a>
            <span>/</span>
            <span class="text-slate-900 font-semibold">{{ $category->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                @if ($category->image_url)
                    <img 
                        src="{{ $category->image_url }}" 
                        alt="{{ $category->name }}" 
                        class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shrink-0"
                    />
                @endif
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                        {{ $category->name }}
                    </h1>
                    @if ($category->description)
                        <p class="text-slate-500 text-xs sm:text-sm mt-1 max-w-2xl">
                            {{ $category->description }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="text-xs text-slate-600 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-200 self-start md:self-auto shrink-0">
                Tersedia: <strong class="text-emerald-800 font-bold">{{ $products->total() }} Produk</strong>
            </div>
        </div>

        {{-- Category Pills --}}
        <div class="flex items-center gap-2 overflow-x-auto pt-5 mt-5 border-t border-slate-100 custom-scrollbar">
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
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold shrink-0 transition-all flex items-center gap-1.5 {{ $isCurrent ? 'bg-[#064E3B] text-white font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}"
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

{{-- PRODUCTS GRID --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Search & Sort Toolbar --}}
    <form action="{{ route('catalog.category', $category->slug) }}" method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari di {{ $category->name }}..." 
                class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:bg-white"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex items-center gap-2">
            <label for="catSort" class="text-xs text-slate-500 font-medium">Urutkan:</label>
            <select 
                id="catSort"
                name="sort"
                onchange="this.form.submit()"
                class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 cursor-pointer"
            >
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Produk Terbaru</option>
                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nama: A – Z</option>
                <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
            </select>
        </div>
    </form>

    @if ($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">
            <p class="font-heading font-bold text-base text-slate-800">Belum ada produk yang sesuai</p>
            <p class="text-xs text-slate-500 mt-1 mb-4">Silakan lihat semua produk pada kategori ini.</p>
            <a href="{{ route('catalog.category', $category->slug) }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#064E3B] text-white text-xs font-bold">
                Reset Pencarian
            </a>
        </div>
    @endif
</div>
@endsection
