@extends('layouts.app')

@section('title', 'Pesanan Berhasil #' . $order->invoice_number . ' — StrikeStore')
@section('meta_description', 'Detail konfirmasi pesanan dan invoice resmi StrikeStore.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    
    {{-- 3-Step Completed Progress --}}
    <div class="flex items-center justify-center gap-2 sm:gap-3 text-xs font-semibold mb-8 print:hidden">
        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
            <span class="w-4 h-4 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px]">✓</span>
            <span>Pilih Produk</span>
        </div>
        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
            <span class="w-4 h-4 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px]">✓</span>
            <span>Data Pemesanan</span>
        </div>
        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <div class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#064E3B] text-white shadow-sm">
            <span class="w-4 h-4 rounded-full bg-emerald-400 text-slate-950 font-extrabold flex items-center justify-center text-[10px]">3</span>
            <span>Pesanan Selesai</span>
        </div>
    </div>

    {{-- Main Invoice Card --}}
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-lg overflow-hidden">
        
        {{-- Top Emerald Banner --}}
        <div class="bg-gradient-to-r from-[#022C22] via-[#064E3B] to-[#022C22] text-white p-6 sm:p-8 text-center sm:text-left flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 uppercase tracking-wider mb-1">
                        Pesanan Berhasil Dibuat
                    </span>
                    <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-white">
                        Terima Kasih, {{ $order->shipping_name }}!
                    </h1>
                    <p class="text-xs text-emerald-100/80 mt-0.5">
                        Pesanan Anda telah tercatat di sistem StrikeStore dan siap diproses.
                    </p>
                </div>
            </div>

            <div class="bg-[#071C17]/80 border border-emerald-700/60 rounded-2xl px-4 py-3 text-center sm:text-right shrink-0">
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 block">Nomor Invoice</span>
                <span class="font-mono font-extrabold text-sm sm:text-base text-white tracking-wide">{{ $order->invoice_number }}</span>
                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            
            {{-- Payment Instructions Box --}}
            <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Metode Pembayaran:</span>
                        <span class="px-2.5 py-0.5 rounded-md bg-emerald-700 text-white text-xs font-bold">
                            {{ $paymentInfo['name'] }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-slate-800 pt-1">
                        {{ $paymentInfo['instructions'] }}
                    </p>
                    @if ($order->transaction?->expired_at)
                        <p class="text-[11px] text-slate-500">
                            Batas waktu konfirmasi pembayaran: <strong>{{ $order->transaction->expired_at->format('d M Y, H:i') }} WIB</strong>
                        </p>
                    @endif
                </div>
                <div class="text-left sm:text-right shrink-0">
                    <span class="text-xs text-slate-500 block">Total yang Harus Dibayar</span>
                    <span class="font-heading font-extrabold text-2xl text-emerald-900">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Customer & Shipping Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5 text-xs">
                    <h3 class="font-heading font-bold text-sm text-slate-900 pb-2 border-b border-slate-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Data Penerima & Alamat Pengiriman</span>
                    </h3>
                    <div class="grid grid-cols-3 gap-2 pt-1">
                        <span class="text-slate-500">Nama Penerima</span>
                        <span class="col-span-2 font-bold text-slate-900">{{ $order->shipping_name }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-slate-500">No. WhatsApp</span>
                        <span class="col-span-2 font-bold text-slate-900">{{ $order->shipping_phone }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-slate-500">Alamat Lengkap</span>
                        <span class="col-span-2 font-medium text-slate-800 leading-relaxed">
                            {{ $order->shipping_address }}
                            @if ($order->shipping_city && $order->shipping_city !== '-')
                                <br>{{ $order->shipping_city }}, {{ $order->shipping_province }} ({{ $order->shipping_postal_code }})
                            @endif
                        </span>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5 text-xs">
                    <h3 class="font-heading font-bold text-sm text-slate-900 pb-2 border-b border-slate-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span>Informasi Pengiriman & Catatan</span>
                    </h3>
                    <div class="grid grid-cols-3 gap-2 pt-1">
                        <span class="text-slate-500">Ekspedisi</span>
                        <span class="col-span-2 font-bold text-slate-900">{{ $order->shipping_method }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-slate-500">Status Pesanan</span>
                        <span class="col-span-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                Menunggu Konfirmasi ({{ ucfirst($order->status) }})
                            </span>
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-slate-500">Kode Transaksi</span>
                        <span class="col-span-2 font-mono font-bold text-slate-800">{{ $order->transaction?->transaction_code ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-slate-500">Catatan</span>
                        <span class="col-span-2 text-slate-700 italic">{{ $order->notes ?: 'Tidak ada catatan khusus' }}</span>
                    </div>
                </div>
            </div>

            {{-- Ordered Products Table --}}
            <div>
                <h3 class="font-heading font-bold text-base text-slate-900 mb-3">Daftar Produk yang Dipesan</h3>
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="divide-y divide-slate-200">
                        @foreach ($order->items as $item)
                            <div class="p-4 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/60 transition-colors">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 shrink-0 flex items-center justify-center">
                                        @if ($item->product && $item->product->image_url)
                                            <img 
                                                src="{{ $item->product->image_url }}" 
                                                alt="{{ $item->product_name }}" 
                                                class="w-full h-full object-cover"
                                            />
                                        @else
                                            <span class="text-[9px] text-slate-400 text-center px-1">Tanpa Foto</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-heading font-bold text-xs sm:text-sm text-slate-900 truncate">{{ $item->product_name }}</h4>
                                        @if ($item->variant)
                                            <span class="inline-block text-[11px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded mt-0.5">
                                                Varian: {{ $item->variant }}
                                            </span>
                                        @endif
                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $item->quantity }} unit × Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="font-heading font-extrabold text-sm text-slate-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals Footer --}}
                    <div class="bg-slate-50 p-5 border-t border-slate-200 space-y-2 text-xs sm:text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal Produk</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Ongkos Kirim ({{ $order->shipping_method }})</span>
                            <span class="font-bold text-slate-900">
                                {{ $order->shipping_cost <= 0 ? 'GRATIS (Rp 0)' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}
                            </span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between text-emerald-700 font-semibold">
                                <span>Potongan Diskon Promo</span>
                                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                            <span class="font-heading font-extrabold text-base text-slate-900">Total Pembayaran</span>
                            <span class="font-heading font-extrabold text-xl sm:text-2xl text-emerald-900">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            @php
                $waItems = '';
                foreach ($order->items as $idx => $it) {
                    $waItems .= "\n" . ($idx + 1) . ". {$it->product_name} (x{$it->quantity}) - Rp " . number_format($it->subtotal, 0, ',', '.');
                    if ($it->variant) {
                        $waItems .= " [{$it->variant}]";
                    }
                }
                $waText = urlencode(
                    "Halo CS StrikeStore, saya ingin konfirmasi pesanan saya:\n\n" .
                    "*No. Invoice:* {$order->invoice_number}\n" .
                    "*Nama:* {$order->shipping_name}\n" .
                    "*No. HP:* {$order->shipping_phone}\n" .
                    "*Alamat:* {$order->shipping_address}\n" .
                    "*Ekspedisi:* {$order->shipping_method}\n" .
                    "*Metode Bayar:* {$paymentInfo['name']}\n" .
                    "*Daftar Produk:*{$waItems}\n\n" .
                    "*Total Tagihan:* Rp " . number_format($order->total, 0, ',', '.') . "\n\n" .
                    "Mohon diproses. Terima kasih!"
                );
            @endphp

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3 print:hidden">
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <a 
                        href="https://wa.me/6285263785531?text={{ $waText }}" 
                        target="_blank" 
                        rel="noopener"
                        class="flex-1 sm:flex-initial py-3.5 px-6 rounded-xl font-heading font-bold text-xs sm:text-sm bg-gradient-to-r from-[#064E3B] to-[#047857] hover:from-[#047857] hover:to-[#10B981] text-white shadow-lg shadow-emerald-950/20 transition-all flex items-center justify-center gap-2"
                    >
                        <span>Konfirmasi via WhatsApp CS</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>

                    <button 
                        type="button" 
                        onclick="window.print()" 
                        class="py-3.5 px-5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-heading font-bold text-xs sm:text-sm transition-colors cursor-pointer"
                    >
                        🖨️ Cetak Invoice
                    </button>
                </div>

                <a 
                    href="{{ route('catalog.index') }}" 
                    class="py-3 px-4 text-xs font-bold text-emerald-800 hover:underline"
                >
                    ← Belanja Produk Lainnya
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

