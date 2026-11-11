@extends('layouts.app')

@section('title', 'Katalog Perlengkapan Memancing — StrikeStore')
@section('meta_description', 'Jelajahi seluruh koleksi perlengkapan memancing terlengkap di StrikeStore: joran, reel, umpan lure, senar PE, kail, dan aksesori memancing.')

@section('content')
<div class="bg-[#F5F7F9] border-b border-[#E8EDF1] py-8 sm:py-10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#7A8791] mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#194668] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#202B35] font-semibold">Katalog Produk</span>
            @if(request('category'))
                <span>/</span>
                <span class="text-[#194668] font-semibold">{{ ucfirst(request('category')) }}</span>
            @endif
        </nav>

        {{-- Heading & Subtitle --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-[#202B35] tracking-tight">
                    All Fishing Gear
                </h1>
                <p class="font-sans text-[#7A8791] text-sm mt-1.5 max-w-2xl">
                    Koleksi lengkap peralatan memancing profesional dari brand terbaik siap dikirim ke lokasi Anda.
                </p>
            </div>
            <div class="text-xs text-[#7A8791] bg-white px-4 py-2.5 rounded-xl border border-[#E8EDF1] shadow-xs shrink-0 self-start md:self-auto">
                Total Tersedia: <strong class="text-[#194668] font-bold">{{ $totalCatalogCount }} Produk</strong>
            </div>
        </div>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- MAIN CATALOG GRID AREA --}}
    <div>
        {{-- Toolbar: Product Count & Sorting --}}
        <div class="bg-white rounded-[18px] border border-[#E8EDF1] p-4 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
            <div class="text-xs sm:text-sm text-[#7A8791]">
                Menampilkan <strong class="text-[#202B35] font-bold">{{ $products->firstItem() ?? 0 }} – {{ $products->lastItem() ?? 0 }}</strong> dari <strong class="text-[#202B35] font-bold">{{ $products->total() }}</strong> hasil
                @if(request('search'))
                    untuk pencarian "<strong class="text-[#194668]">{{ request('search') }}</strong>"
                @endif
                @if(request('brand'))
                    brand <strong class="text-[#194668]">{{ request('brand') }}</strong>
                @endif
            </div>

            {{-- Sort Selector Form --}}
            <form action="{{ route('catalog.index') }}" method="GET" class="flex items-center gap-2">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                @endif
                <label for="sortSelector" class="text-xs text-[#7A8791] whitespace-nowrap font-medium">Urutkan:</label>
                <select 
                    id="sortSelector"
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
            </form>
        </div>

        {{-- Products Grid (4 Columns on Desktop) --}}
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-[20px] border border-[#E8EDF1] p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-[#F5F7F9] text-[#194668] mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-xl text-[#202B35] mb-2">
                    Tidak ada produk yang cocok
                </h3>
                <p class="text-sm text-[#7A8791] max-w-md mx-auto mb-6">
                    Kami tidak menemukan peralatan memancing yang sesuai dengan kata kunci Anda.
                </p>
                <a 
                    href="{{ route('catalog.index') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#194668] text-white font-semibold text-xs hover:bg-[#102D42] transition-colors shadow-xs"
                >
                    <span>Lihat Semua Produk</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
