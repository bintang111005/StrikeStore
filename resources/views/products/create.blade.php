@extends('layouts.app')

@section('title', 'Tambah Produk Baru')
@section('meta_description', 'Tambahkan produk memancing baru ke toko StrikeStore Anda.')

@section('content')
<div class="animate-fade-in">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Tambah Produk Baru</h1>
            <p>Isi detail produk perlengkapan memancing yang ingin ditambahkan</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.25rem; list-style: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            {{-- Left Column: Main Info --}}
            <div>
                <div class="card">
                    <div class="card-body">
                        <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--color-text);">
                            Informasi Produk
                        </h2>

                        <div class="form-group">
                            <label class="form-label">Nama Produk <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Joran Shimano Nexave 180cm" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori <span class="required">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Deskripsikan produk secara detail...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-top: 1.5rem;">
                    <div class="card-body">
                        <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--color-text);">
                            Harga & Inventori
                        </h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="0" min="0" step="100" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Harga Diskon (Rp)</label>
                                <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price') }}" placeholder="Kosongkan jika tidak ada diskon" min="0" step="100">
                                <span class="form-hint">Harus lebih rendah dari harga normal</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Stok <span class="required">*</span></label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="Contoh: JRN-SHM-180">
                                <span class="form-hint">Kode unik untuk identifikasi produk</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Berat (gram)</label>
                                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="0" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Image & Status --}}
            <div>
                <div class="card">
                    <div class="card-body">
                        <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--color-text);">
                            Gambar Produk
                        </h2>

                        <div class="form-group">
                            <div class="file-upload" id="dropZone">
                                <div>
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 0.75rem; color: var(--color-text-muted);"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <p style="font-size: 0.875rem; color: var(--color-text-muted);">
                                        <span style="color: var(--color-primary); font-weight: 600;">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 0.25rem;">
                                        PNG, JPG, WEBP (maks. 2MB)
                                    </p>
                                </div>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this)">
                            </div>
                            <img id="imagePreview" class="image-preview" style="display:none;">
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-top: 1.5rem;">
                    <div class="card-body">
                        <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--color-text);">
                            Status & Visibilitas
                        </h2>

                        <div class="form-group">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="out_of_stock" {{ old('status') === 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-check">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <div>
                                    <span class="form-label" style="margin-bottom: 0;">Produk Unggulan</span>
                                    <span class="form-hint" style="display: block;">Tampilkan produk ini di halaman utama</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
