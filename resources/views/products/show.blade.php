@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<div class="animate-fade-in">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>{{ $product->name }}</h1>
            <p>Detail lengkap produk</p>
        </div>
        <div class="actions-group">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">
        {{-- Left: Product Image --}}
        <div>
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="detail-image">
            @else
                <div class="detail-image-placeholder">
                    <div style="text-align: center;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p style="margin-top: 0.75rem; font-size: 0.875rem;">Belum ada gambar</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Product Details --}}
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                        @if ($product->category)
                            <span class="badge badge-category">{{ $product->category->name }}</span>
                        @endif
                        @switch($product->status)
                            @case('active')
                                <span class="badge badge-active">● Aktif</span>
                                @break
                            @case('inactive')
                                <span class="badge badge-inactive">● Nonaktif</span>
                                @break
                            @case('out_of_stock')
                                <span class="badge badge-out-of-stock">● Stok Habis</span>
                                @break
                        @endswitch
                        @if ($product->is_featured)
                            <span class="badge badge-featured">⭐ Unggulan</span>
                        @endif
                    </div>

                    {{-- Price --}}
                    <div style="margin-bottom: 1.5rem;">
                        @if ($product->discount_price)
                            <span style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary-light);">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </span>
                            <span class="price-original" style="font-size: 1rem; margin-left: 0.5rem;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @php
                                $discount = round(($product->price - $product->discount_price) / $product->price * 100);
                            @endphp
                            <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); margin-left: 0.5rem;">
                                -{{ $discount }}%
                            </span>
                        @else
                            <span style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary-light);">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if ($product->description)
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-size: 0.75rem; font-weight: 600; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Deskripsi</h3>
                            <p style="color: var(--color-text); line-height: 1.7; white-space: pre-line;">{{ $product->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="detail-info-grid">
                <div class="detail-info-item">
                    <dt>Stok</dt>
                    <dd style="font-size: 1.25rem; font-weight: 700; {{ $product->stock <= 5 ? 'color: #f87171;' : '' }}">
                        {{ $product->stock }} unit
                    </dd>
                </div>
                @if ($product->sku)
                    <div class="detail-info-item">
                        <dt>SKU</dt>
                        <dd style="font-family: monospace;">{{ $product->sku }}</dd>
                    </div>
                @endif
                @if ($product->weight)
                    <div class="detail-info-item">
                        <dt>Berat</dt>
                        <dd>{{ number_format($product->weight, 0, ',', '.') }} gram</dd>
                    </div>
                @endif
                <div class="detail-info-item">
                    <dt>Dilihat</dt>
                    <dd>{{ number_format($product->views_count) }}×</dd>
                </div>
                <div class="detail-info-item">
                    <dt>Dibuat</dt>
                    <dd>{{ $product->created_at->format('d M Y') }}</dd>
                </div>
                <div class="detail-info-item">
                    <dt>Diperbarui</dt>
                    <dd>{{ $product->updated_at->format('d M Y') }}</dd>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
