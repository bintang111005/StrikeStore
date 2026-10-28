@extends('layouts.app')

@section('title', "Edit: {$product->name} — StrikeStore Admin")
@section('meta_description', "Edit produk {$product->name} di StrikeStore.")

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-emerald-400 transition-colors">Manajemen Produk</a>
        <span>/</span>
        <span class="text-slate-300 font-medium">Edit Produk</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex items-center justify-between pb-6 border-b border-emerald-900/30 mb-8">
        <div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">
                Edit Produk
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">
                Perbarui detail inventori <strong class="text-emerald-300">{{ $product->name }}</strong>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a 
                href="{{ route('catalog.show', $product->slug) }}" 
                target="_blank"
                class="px-3.5 py-2.5 rounded-xl border border-emerald-700/80 bg-[#071C17] hover:bg-emerald-950 text-slate-200 hover:text-white text-xs font-bold transition-all flex items-center gap-2 shadow-sm"
            >
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>Lihat di Toko</span>
            </a>
            <a 
                href="{{ route('products.index') }}" 
                class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all flex items-center gap-2 shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
            <div class="font-bold mb-1 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Terdapat Kesalahan Pengisian Formulir:
            </div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Main Information (2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Box 1: Info Dasar --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-4">
                    <h2 class="font-heading font-bold text-sm text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Informasi Utama Produk
                    </h2>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $product->name) }}" 
                            placeholder="Contoh: Joran Shimano Bassterra EV 180cm" 
                            required 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Kategori Produk <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            name="category_id" 
                            required 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="">Pilih Kategori...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Deskripsi Lengkap
                        </label>
                        <textarea 
                            name="description" 
                            rows="5" 
                            placeholder="Jelaskan fitur, material blank carbon, drag rating, dan kegunaan piranti..." 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                {{-- Box 2: Harga & Stok --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-4">
                    <h2 class="font-heading font-bold text-sm text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Harga & Inventori
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Harga Normal (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="price" 
                                value="{{ old('price', $product->price) }}" 
                                placeholder="850000" 
                                min="0" 
                                step="1000" 
                                required 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Harga Diskon Promo (Rp)
                            </label>
                            <input 
                                type="number" 
                                name="discount_price" 
                                value="{{ old('discount_price', $product->discount_price) }}" 
                                placeholder="Kosongkan bila tidak diskon" 
                                min="0" 
                                step="1000" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                            <p class="text-[11px] text-slate-400 mt-1">Harus lebih rendah dari harga normal.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Jumlah Stok Unit <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="stock" 
                                value="{{ old('stock', $product->stock) }}" 
                                min="0" 
                                required 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Kode SKU Produk
                            </label>
                            <input 
                                type="text" 
                                name="sku" 
                                value="{{ old('sku', $product->sku) }}" 
                                placeholder="Contoh: JRN-SHM-001" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Berat Paket (gram)
                            </label>
                            <input 
                                type="number" 
                                name="weight" 
                                value="{{ old('weight', $product->weight) }}" 
                                min="0" 
                                step="1" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Media, Status, Actions (1 col) --}}
            <div class="space-y-6">
                {{-- Box 3: Gambar Produk --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-4">
                    <h2 class="font-heading font-bold text-sm text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Gambar Produk
                    </h2>

                    {{-- Current Image Display --}}
                    @if ($product->image)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Saat Ini:</p>
                            <img 
                                src="{{ Storage::url($product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-32 h-32 object-cover rounded-xl border border-slate-200 mx-auto shadow-sm"
                            />
                        </div>
                    @endif

                    <div>
                        <div class="border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-6 text-center cursor-pointer transition-colors bg-slate-50/50 relative">
                            <input 
                                type="file" 
                                name="image" 
                                accept="image/jpeg,image/png,image/webp" 
                                onchange="previewImage(this)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            />
                            <div class="space-y-2">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="text-emerald-700 font-bold">Ganti foto baru</span> atau seret ke sini
                                </div>
                                <p class="text-[11px] text-slate-400">PNG, JPG, WEBP (maks. 2MB)</p>
                            </div>
                        </div>

                        {{-- New Preview Box --}}
                        <div id="previewContainer" class="hidden mt-3 text-center">
                            <img id="imagePreview" class="w-32 h-32 object-cover rounded-xl border border-slate-200 mx-auto shadow-sm" />
                            <p class="text-[11px] text-emerald-600 mt-1 font-semibold">Preview foto baru terpilih</p>
                        </div>
                    </div>
                </div>

                {{-- Box 4: Status & Visibilitas --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-4">
                    <h2 class="font-heading font-bold text-sm text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Status & Visibilitas
                    </h2>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Status Produk <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            name="status" 
                            required 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Aktif (Tampil di Toko)</option>
                            <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Nonaktif (Draft / Sembunyi)</option>
                            <option value="out_of_stock" {{ old('status', $product->status) === 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="hidden" name="is_featured" value="0">
                            <input 
                                type="checkbox" 
                                name="is_featured" 
                                value="1" 
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer"
                            />
                            <div>
                                <span class="text-xs font-bold text-slate-800">Jadikan Produk Unggulan</span>
                                <p class="text-[11px] text-slate-400">Tampilkan di slider rekomendasi homepage StrikeStore.</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 py-3 px-4 rounded-xl font-heading font-bold text-xs bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                    <a 
                        href="{{ route('products.index') }}" 
                        class="py-3 px-5 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all text-center"
                    >
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('previewContainer');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
