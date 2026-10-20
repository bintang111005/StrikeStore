@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('meta_description', 'Kelola semua produk perlengkapan memancing — joran, reel, umpan, senar, dan lainnya.')

@section('content')
<div class="animate-fade-in">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Daftar Produk</h1>
            <p>Kelola semua produk perlengkapan memancing Anda</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #38bdf8;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: #4ade80;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $activeProducts }}</div>
                <div class="stat-label">Produk Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #f87171;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $outOfStock }}</div>
                <div class="stat-label">Stok Habis</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #fbbf24;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $featuredProducts }}</div>
                <div class="stat-label">Produk Unggulan</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form action="{{ route('products.index') }}" method="GET" class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
        <select name="category" class="form-control" style="max-width: 200px;" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-control" style="max-width: 180px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Cari
        </button>
        @if (request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Hapus Filter</a>
        @endif
    </form>

    {{-- Products Table --}}
    @if ($products->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb">
                                @else
                                    <div class="product-thumb-placeholder">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $product->name }}</div>
                                @if ($product->sku)
                                    <div style="font-size: 0.75rem; color: var(--color-text-muted);">SKU: {{ $product->sku }}</div>
                                @endif
                                @if ($product->is_featured)
                                    <span class="badge badge-featured" style="margin-top: 0.25rem;">⭐ Unggulan</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->category)
                                    <span class="badge badge-category">{{ $product->category->name }}</span>
                                @else
                                    <span style="color: var(--color-text-muted);">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->discount_price)
                                    <span class="price">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    <br>
                                    <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-weight: 600; {{ $product->stock <= 5 ? 'color: #f87171;' : '' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                @switch($product->status)
                                    @case('active')
                                        <span class="badge badge-active">● Aktif</span>
                                        @break
                                    @case('inactive')
                                        <span class="badge badge-inactive">● Nonaktif</span>
                                        @break
                                    @case('out_of_stock')
                                        <span class="badge badge-out-of-stock">● Habis</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="actions-group">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-icon" title="Lihat">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-icon" title="Edit">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <h3>Belum Ada Produk</h3>
                <p>Mulai tambahkan produk perlengkapan memancing Anda.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Produk Pertama
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
