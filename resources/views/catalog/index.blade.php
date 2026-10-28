@extends('layouts.app')

@section('title', 'Katalog Perlengkapan Memancing — StrikeStore')
@section('meta_description', 'Jelajahi seluruh koleksi perlengkapan memancing terlengkap di StrikeStore: joran, reel, umpan lure, senar PE, kail, dan aksesori memancing.')

@section('content')
<div class="bg-slate-50 border-b border-slate-200/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-900 font-semibold">Katalog Produk</span>
            @if(request('category'))
                <span>/</span>
                <span class="text-emerald-700 font-semibold">{{ ucfirst(request('category')) }}</span>
            @endif
        </nav>

        {{-- Heading & Subtitle --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight">
                    All Fishing Gear
                </h1>
                <p class="text-slate-500 text-sm mt-1.5 max-w-2xl">
                    Koleksi lengkap peralatan memancing profesional. Filter berdasarkan kategori, brand ternama, kisaran harga, atau ketersediaan stok.
                </p>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-xs shrink-0 self-start md:self-auto">
                Total Tersedia: <strong class="text-emerald-800 font-bold">{{ $totalCatalogCount }} Produk</strong>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

        {{-- SIDEBAR FILTERS (Desktop) & Trigger (Mobile) --}}
        <aside class="lg:col-span-1">
            {{-- Mobile Filter Trigger Button --}}
            <div class="lg:hidden mb-4">
                <button 
                    type="button" 
                    onclick="openMobileFilterDrawer()"
                    class="w-full py-3.5 px-4 rounded-xl bg-white border border-slate-300 text-slate-800 font-bold text-sm flex items-center justify-between shadow-xs hover:border-emerald-600 transition-colors cursor-pointer"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        Filter & Pencarian Produk
                    </span>
                    @if (request()->hasAny(['search', 'category', 'brand', 'availability', 'min_price', 'max_price']))
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                    @else
                        <span class="text-xs text-emerald-700 font-semibold">Buka Filter →</span>
                    @endif
                </button>
            </div>

            {{-- Desktop Filter Box --}}
            <div class="hidden lg:block bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm sticky top-28 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-base text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter Produk
                    </h3>
                    @if (request()->hasAny(['search', 'category', 'brand', 'availability', 'min_price', 'max_price', 'sort']))
                        <a href="{{ route('catalog.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold underline">
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
                    {{-- Retain sort parameter --}}
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    {{-- Search Input --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kata Kunci</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Nama, SKU, merk..." 
                                class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:bg-white"
                            />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kategori</label>
                        <div class="space-y-1.5">
                            <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer text-xs {{ !request('category') ? 'bg-emerald-50 text-emerald-900 font-bold' : 'text-slate-700' }}">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="text-emerald-600 focus:ring-emerald-500">
                                    <span>Semua Kategori</span>
                                </div>
                                <span class="text-slate-400 text-[11px]">{{ $totalCatalogCount }}</span>
                            </label>

                            @foreach ($categories as $cat)
                                @php
                                    $isSelected = request('category') == $cat->slug || request('category') == $cat->id;
                                @endphp
                                <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer text-xs {{ $isSelected ? 'bg-emerald-50 text-emerald-900 font-bold' : 'text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" {{ $isSelected ? 'checked' : '' }} onchange="this.form.submit()" class="text-emerald-600 focus:ring-emerald-500">
                                        <span>{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-slate-400 text-[11px]">{{ $cat->products_count }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brand Filter --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Brand Populer</label>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($availableBrands as $brand)
                                @php
                                    $isBrandActive = request('brand') === $brand;
                                @endphp
                                <button 
                                    type="submit" 
                                    name="brand" 
                                    value="{{ $isBrandActive ? '' : $brand }}"
                                    class="px-2.5 py-1.5 rounded-lg text-xs font-medium border text-left transition-colors truncate cursor-pointer {{ $isBrandActive ? 'bg-emerald-700 text-white border-emerald-700 font-bold' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-slate-300' }}"
                                >
                                    {{ $brand }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Availability Filter --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Ketersediaan Stok</label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 p-1.5 text-xs text-slate-700 cursor-pointer">
                                <input type="radio" name="availability" value="" {{ !request('availability') ? 'checked' : '' }} onchange="this.form.submit()" class="text-emerald-600">
                                <span>Semua Status</span>
                            </label>
                            <label class="flex items-center gap-2 p-1.5 text-xs text-slate-700 cursor-pointer">
                                <input type="radio" name="availability" value="in_stock" {{ request('availability') === 'in_stock' ? 'checked' : '' }} onchange="this.form.submit()" class="text-emerald-600">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Hanya Siap Kirim (In Stock)
                                </span>
                            </label>
                            <label class="flex items-center gap-2 p-1.5 text-xs text-slate-700 cursor-pointer">
                                <input type="radio" name="availability" value="out_of_stock" {{ request('availability') === 'out_of_stock' ? 'checked' : '' }} onchange="this.form.submit()" class="text-emerald-600">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Stok Habis
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Price Filter --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Rentang Harga (Rp)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ request('min_price') }}"
                                placeholder="Min" 
                                class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                            />
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ request('max_price') }}"
                                placeholder="Max" 
                                class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                            />
                        </div>
                        <div class="flex flex-wrap gap-1 mt-2">
                            <a href="{{ route('catalog.index', array_merge(request()->except(['min_price', 'max_price']), ['max_price' => 300000])) }}" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 text-[10px] text-slate-600">
                                &lt; 300rb
                            </a>
                            <a href="{{ route('catalog.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 300000, 'max_price' => 750000])) }}" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 text-[10px] text-slate-600">
                                300rb - 750rb
                            </a>
                            <a href="{{ route('catalog.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 750000])) }}" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 text-[10px] text-slate-600">
                                &gt; 750rb
                            </a>
                        </div>
                        <button type="submit" class="w-full mt-3 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-emerald-700 transition-colors cursor-pointer">
                            Terapkan Rentang Harga
                        </button>
                    </div>
                </form>
            </div>
        </aside>

        {{-- MAIN CATALOG GRID AREA --}}
        <main class="lg:col-span-3">
            {{-- Toolbar: Product Count & Sorting --}}
            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
                <div class="text-xs sm:text-sm text-slate-600">
                    Menampilkan <strong class="text-slate-900 font-bold">{{ $products->firstItem() ?? 0 }} – {{ $products->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-900 font-bold">{{ $products->total() }}</strong> hasil
                    @if(request('search'))
                        untuk pencarian "<strong class="text-emerald-700">{{ request('search') }}</strong>"
                    @endif
                    @if(request('brand'))
                        brand <strong class="text-emerald-700">{{ request('brand') }}</strong>
                    @endif
                </div>

                {{-- Sort Selector --}}
                <div class="flex items-center gap-2">
                    <label for="sortSelector" class="text-xs text-slate-500 whitespace-nowrap font-medium">Urutkan:</label>
                    <select 
                        id="sortSelector"
                        name="sort" 
                        onchange="const url = new URL(window.location.href); url.searchParams.set('sort', this.value); window.location.href = url.toString();"
                        class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 cursor-pointer"
                    >
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Produk Terbaru</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nama: A – Z</option>
                        <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                    </select>
                </div>
            </div>

            {{-- Products Grid --}}
            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                {{-- Empty State with Clean SVG --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-slate-900 mb-2">
                        Tidak ada produk yang cocok
                    </h3>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                        Kami tidak menemukan peralatan memancing yang sesuai dengan filter atau kata kunci Anda. Silakan coba atur ulang filter Anda.
                    </p>
                    <a 
                        href="{{ route('catalog.index') }}" 
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#064E3B] text-white font-bold text-xs hover:bg-emerald-700 transition-colors shadow-md"
                    >
                        <span>Hapus Semua Filter</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            @endif
        </main>

    </div>
</div>

{{-- MOBILE FILTER DRAWER --}}
<div id="mobileFilterBackdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeMobileFilterDrawer()"></div>
<div id="mobileFilterDrawer" class="fixed top-0 right-0 bottom-0 w-80 max-w-[88vw] bg-white z-50 translate-x-full transition-transform duration-300 flex flex-col justify-between p-6 overflow-y-auto custom-scrollbar">
    <div>
        <div class="flex items-center justify-between pb-4 border-b border-slate-200">
            <h3 class="font-heading font-bold text-base text-slate-900">Filter Produk</h3>
            <button type="button" onclick="closeMobileFilterDrawer()" class="p-2 text-slate-400 hover:text-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-5 mt-5">
            {{-- Retain sort --}}
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Cari Produk</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs" />
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kategori</label>
                <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->products_count }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Ketersediaan</label>
                <select name="availability" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
                    <option value="">Semua Status</option>
                    <option value="in_stock" {{ request('availability') === 'in_stock' ? 'selected' : '' }}>Hanya yang Siap Kirim</option>
                    <option value="out_of_stock" {{ request('availability') === 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Rentang Harga (Rp)</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs" />
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs" />
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 rounded-xl bg-[#064E3B] text-white text-xs font-bold hover:bg-emerald-700 transition-colors shadow-md">
                    Terapkan Filter
                </button>
                <a href="{{ route('catalog.index') }}" class="block text-center mt-2.5 text-xs text-rose-600 font-semibold underline">
                    Reset Semua
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openMobileFilterDrawer() {
        document.getElementById('mobileFilterDrawer').classList.remove('translate-x-full');
        document.getElementById('mobileFilterBackdrop').classList.remove('opacity-0', 'pointer-events-none');
    }
    function closeMobileFilterDrawer() {
        document.getElementById('mobileFilterDrawer').classList.add('translate-x-full');
        document.getElementById('mobileFilterBackdrop').classList.add('opacity-0', 'pointer-events-none');
    }
</script>
@endpush
@endsection
