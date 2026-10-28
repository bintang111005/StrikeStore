@extends('layouts.app')

@section('title', 'Manajemen Produk — StrikeStore Admin')
@section('meta_description', 'Kelola semua produk perlengkapan memancing — joran, reel, umpan, senar, dan lainnya.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">

    {{-- Breadcrumb & Top Bar --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Home</a>
        <span>/</span>
        <span class="text-emerald-400 font-semibold">Portal Admin</span>
        <span>/</span>
        <span class="text-slate-300 font-medium">Manajemen Produk</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-emerald-900/30 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Katalog & Inventaris</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-emerald-400 tracking-tight">
                Manajemen Produk Pancing
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">
                Kelola katalog inventaris, stok, harga diskon, dan status produk StrikeStore.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a 
                href="{{ route('catalog.index') }}" 
                target="_blank"
                class="px-4 py-2.5 rounded-xl border border-emerald-700/80 bg-[#071C17] hover:bg-emerald-950 text-slate-200 hover:text-white text-xs font-bold transition-all flex items-center gap-2 shadow-sm"
                title="Buka Toko / Halaman Katalog Publik"
            >
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Katalog Toko</span>
            </a>
            <a 
                href="{{ route('products.create') }}" 
                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-lg shadow-emerald-950/40 active:scale-95"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        {{-- Card 1: Total Produk --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <div class="font-heading font-extrabold text-2xl text-slate-900 leading-none">{{ $totalProducts }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-1">Total Produk</div>
            </div>
        </div>

        {{-- Card 2: Produk Aktif --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="font-heading font-extrabold text-2xl text-emerald-700 leading-none">{{ $activeProducts }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-1">Produk Aktif</div>
            </div>
        </div>

        {{-- Card 3: Stok Habis --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <div class="font-heading font-extrabold text-2xl text-rose-600 leading-none">{{ $outOfStock }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-1">Stok Habis / Kritis</div>
            </div>
        </div>

        {{-- Card 4: Produk Unggulan --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
            <div>
                <div class="font-heading font-extrabold text-2xl text-amber-600 leading-none">{{ $featuredProducts }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-1">Produk Unggulan</div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Card --}}
    <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm mb-6">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
            {{-- Search Input --}}
            <div class="relative flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama produk, SKU, atau deskripsi..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all bg-slate-50 focus:bg-white"
                />
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Category Filter --}}
            <div class="w-full md:w-52">
                <select 
                    name="category" 
                    onchange="this.form.submit()"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all bg-slate-50 focus:bg-white"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full md:w-44">
                <select 
                    name="status" 
                    onchange="this.form.submit()"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all bg-slate-50 focus:bg-white"
                >
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>

            {{-- Submit & Clear Buttons --}}
            <div class="flex items-center gap-2">
                <button 
                    type="submit" 
                    class="px-4 py-2.5 rounded-xl bg-[#064E3B] hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center justify-center gap-1.5 shrink-0 shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Cari</span>
                </button>

                @if (request()->hasAny(['search', 'category', 'status']))
                    <a 
                        href="{{ route('products.index') }}" 
                        class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 text-xs font-bold transition-all shrink-0"
                        title="Hapus Filter"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Products Data Table --}}
    @if ($products->count() > 0)
        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/90 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-16 text-center">Gambar</th>
                            <th class="py-3.5 px-4">Nama Produk & SKU</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Harga</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach ($products as $product)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                {{-- Thumbnail --}}
                                <td class="py-3 px-4 text-center">
                                    <img 
                                        src="{{ $product->image_url }}" 
                                        alt="{{ $product->name }}" 
                                        loading="lazy"
                                        class="w-12 h-12 object-cover rounded-xl bg-white border border-slate-200 mx-auto shadow-xs"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=600&q=80';"
                                    />
                                </td>

                                {{-- Name & SKU --}}
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 group-hover:text-emerald-800 transition-colors">
                                        {{ $product->name }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if ($product->sku)
                                            <span class="font-mono text-[11px] text-slate-400">SKU: {{ $product->sku }}</span>
                                        @endif
                                        @if ($product->is_featured)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                ★ Unggulan
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Category --}}
                                <td class="py-3 px-4">
                                    @if ($product->category)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Price --}}
                                <td class="py-3 px-4">
                                    @if ($product->discount_price)
                                        <div class="font-extrabold text-emerald-800">
                                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 line-through">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="font-bold text-slate-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Stock --}}
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $product->stock <= 5 ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-800' }}">
                                        {{ $product->stock }} unit
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="py-3 px-4 text-center">
                                    @switch($product->status)
                                        @case('active')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                                Aktif
                                            </span>
                                            @break
                                        @case('inactive')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Nonaktif
                                            </span>
                                            @break
                                        @case('out_of_stock')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Habis
                                            </span>
                                            @break
                                    @endswitch
                                </td>

                                {{-- Actions --}}
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- View in Store --}}
                                        <a 
                                            href="{{ route('catalog.show', $product->slug) }}" 
                                            target="_blank"
                                            class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-600 hover:text-emerald-800 border border-slate-200 flex items-center justify-center transition-colors"
                                            title="Lihat Tampilan Toko"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        {{-- Edit Product --}}
                                        <a 
                                            href="{{ route('products.edit', $product) }}" 
                                            class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 flex items-center justify-center transition-colors"
                                            title="Edit Produk"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        {{-- Delete Product --}}
                                        <form 
                                            action="{{ route('products.destroy', $product) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk: {{ $product->name }}?')"
                                            class="inline-block"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-800 border border-rose-200 flex items-center justify-center transition-colors cursor-pointer"
                                                title="Hapus Produk"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            @if ($products->hasPages())
                {{ $products->links('vendor.pagination.custom') }}
            @endif
        </div>
    @else
        {{-- Empty State --}}
        <div class="rounded-3xl bg-white border border-slate-200 p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="font-heading font-extrabold text-lg text-slate-900 mb-1">
                Belum Ada Produk Ditemukan
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6">
                Tidak ada produk yang cocok dengan kriteria pencarian atau filter yang dipilih.
            </p>
            <div class="flex items-center justify-center gap-3">
                <a 
                    href="{{ route('products.index') }}" 
                    class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all"
                >
                    Reset Filter
                </a>
                <a 
                    href="{{ route('products.create') }}" 
                    class="px-5 py-2.5 rounded-xl bg-[#064E3B] hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md flex items-center gap-1.5"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Produk Baru</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
