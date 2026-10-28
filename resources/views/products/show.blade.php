@extends('layouts.app')

@section('title', "{$product->name} — StrikeStore Admin")
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-emerald-400 transition-colors">Manajemen Produk</a>
        <span>/</span>
        <span class="text-slate-300 font-medium truncate max-w-xs">{{ $product->name }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-emerald-900/30 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider mb-2">
                <span>Detail Inventori Produk</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">
                {{ $product->name }}
            </h1>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            {{-- Public Catalog View --}}
            <a 
                href="{{ route('catalog.show', $product->slug) }}" 
                target="_blank"
                class="px-3.5 py-2 rounded-xl border border-emerald-700/80 bg-[#071C17] hover:bg-emerald-950 text-slate-200 hover:text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm"
            >
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>Lihat di Toko</span>
            </a>

            {{-- Edit Button --}}
            <a 
                href="{{ route('products.edit', $product) }}" 
                class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold transition-all flex items-center gap-1.5 shadow-md"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit</span>
            </a>

            {{-- Delete Button --}}
            <form 
                action="{{ route('products.destroy', $product) }}" 
                method="POST" 
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                class="inline-block"
            >
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-md cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus</span>
                </button>
            </form>

            <a 
                href="{{ route('products.index') }}" 
                class="px-4 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all"
            >
                Kembali
            </a>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        {{-- Left: Image Card (5 cols) --}}
        <div class="md:col-span-5">
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm text-center">
                <img 
                    src="{{ $product->image_url }}" 
                    alt="{{ $product->name }}" 
                    class="w-full aspect-square object-cover rounded-xl border border-slate-200 shadow-inner"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=800&q=80';"
                />

                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-around text-xs text-slate-500">
                    <div>
                        <span class="block font-bold text-slate-800">{{ $product->views_count }}</span>
                        <span>Total Dilihat</span>
                    </div>
                    <div class="border-l border-slate-200 pl-4">
                        <span class="block font-bold text-slate-800">{{ $product->created_at->format('d/m/Y') }}</span>
                        <span>Tanggal Input</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Product Attributes & Details (7 cols) --}}
        <div class="md:col-span-7 space-y-6">
            {{-- Main Attributes Card --}}
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-4">
                <div class="flex items-center gap-2 flex-wrap">
                    @if ($product->category)
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    @switch($product->status)
                        @case('active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                Aktif di Toko
                            </span>
                            @break
                        @case('inactive')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Nonaktif (Draft)
                            </span>
                            @break
                        @case('out_of_stock')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                Stok Habis
                            </span>
                            @break
                    @endswitch

                    @if ($product->is_featured)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            ★ Produk Rekomendasi
                        </span>
                    @endif
                </div>

                {{-- Price Display --}}
                <div class="py-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Harga Jual:</span>
                    @if ($product->discount_price)
                        <div class="flex items-baseline gap-3">
                            <span class="font-heading font-extrabold text-3xl text-emerald-800">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-slate-400 line-through">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @php
                                $pct = round((($product->price - $product->discount_price) / $product->price) * 100);
                            @endphp
                            <span class="px-2 py-0.5 rounded-md text-xs font-extrabold bg-rose-100 text-rose-700">
                                Hemat {{ $pct }}%
                            </span>
                        </div>
                    @else
                        <div class="font-heading font-extrabold text-3xl text-slate-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                @if ($product->description)
                    <div class="pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Deskripsi Produk:</span>
                        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ $product->description }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Technical Specs Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-xl bg-white border border-slate-200/90 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Sisa Stok</span>
                    <span class="text-base font-extrabold {{ $product->stock <= 5 ? 'text-rose-600' : 'text-slate-900' }}">
                        {{ $product->stock }} unit
                    </span>
                </div>

                <div class="p-4 rounded-xl bg-white border border-slate-200/90 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">SKU Code</span>
                    <span class="text-xs font-mono font-bold text-slate-800 truncate block">
                        {{ $product->sku ?: '—' }}
                    </span>
                </div>

                <div class="p-4 rounded-xl bg-white border border-slate-200/90 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Berat Paket</span>
                    <span class="text-base font-extrabold text-slate-900">
                        {{ $product->weight ? number_format($product->weight, 0, ',', '.') . ' g' : '—' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
