@extends('layouts.app')

@section('title', $category->name . ' — StrikeStore')
@section('meta_description', $category->description ?? 'Koleksi ' . $category->name . ' di StrikeStore.')

@section('content')
{{-- CLEAN CATEGORY HEADER --}}
<div class="bg-[#F5F7F9] border-b border-[#E8EDF1] py-8 sm:py-10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-[#7A8791] mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#194668] transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-[#194668] transition-colors">Katalog</a>
            <span>/</span>
            <span class="text-[#202B35] font-semibold">{{ $category->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                @if ($category->image_url)
                    <img 
                        src="{{ $category->image_url }}" 
                        alt="{{ $category->name }}" 
                        class="w-16 h-16 rounded-2xl object-cover border border-[#E8EDF1] shrink-0"
                    />
                @endif
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-[#202B35] tracking-tight">
                        {{ $category->name }}
                    </h1>
                    @if ($category->description)
                        <p class="text-[#7A8791] text-xs sm:text-sm mt-1 max-w-2xl">
                            {{ $category->description }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="text-xs text-[#7A8791] bg-white px-4 py-2.5 rounded-xl border border-[#E8EDF1] self-start md:self-auto shrink-0">
                Tersedia: <strong class="text-[#194668] font-bold">{{ $products->total() }} Produk</strong>
            </div>
        </div>

        {{-- Category Pills --}}
        <div class="flex items-center gap-2 overflow-x-auto pt-5 mt-5 border-t border-[#E8EDF1] custom-scrollbar">
            <a 
                href="{{ route('catalog.index') }}" 
                class="px-4 py-2 rounded-full text-xs font-semibold shrink-0 transition-colors bg-white hover:bg-[#DCE5EB]/50 text-[#202B35] border border-[#E8EDF1]"
            >
                Semua Produk
            </a>
            @foreach ($allCategories as $cat)
                @php
                    $isCurrent = $cat->id === $category->id;
                @endphp
                <a 
                    href="{{ route('catalog.category', $cat->slug) }}" 
                    class="px-4 py-2 rounded-full text-xs font-semibold shrink-0 transition-all flex items-center gap-1.5 {{ $isCurrent ? 'bg-[#194668] text-white' : 'bg-white hover:bg-[#DCE5EB]/50 text-[#202B35] border border-[#E8EDF1]' }}"
                >
                    <span>{{ $cat->name }}</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $isCurrent ? 'bg-[#C5804B] text-white font-bold' : 'bg-[#F5F7F9] text-[#7A8791]' }}">
                        {{ $cat->products_count }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- PRODUCTS GRID --}}
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    {{-- Search & Sort Toolbar --}}
    <form action="{{ route('catalog.category', $category->slug) }}" method="GET" class="bg-white rounded-[18px] border border-[#E8EDF1] p-4 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
        <div class="relative flex-1 max-w-sm">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari di {{ $category->name }}..." 
                class="w-full pl-9 pr-4 py-2 bg-[#F5F7F9] border border-[#E8EDF1] rounded-xl text-xs text-[#202B35] placeholder-[#7A8791] focus:outline-none focus:border-[#194668] focus:bg-white"
            />
            <svg class="w-4 h-4 text-[#7A8791] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex items-center gap-2">
            <label for="catSort" class="text-xs text-[#7A8791] font-medium">Urutkan:</label>
            <select 
                id="catSort"
                name="sort"
                onchange="this.form.submit()"
                class="text-xs font-semibold bg-[#F5F7F9] border border-[#E8EDF1] rounded-xl px-3.5 py-2 text-[#202B35] focus:outline-none focus:border-[#194668] cursor-pointer"
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-[20px] border border-[#E8EDF1] p-10 text-center">
            <p class="font-heading font-bold text-base text-[#202B35]">Belum ada produk yang sesuai</p>
            <p class="text-xs text-[#7A8791] mt-1 mb-4">Silakan lihat semua produk pada kategori ini.</p>
            <a href="{{ route('catalog.category', $category->slug) }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#194668] text-white text-xs font-semibold">
                Reset Pencarian
            </a>
        </div>
    @endif
</div>
@endsection
