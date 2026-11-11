@extends('layouts.app')

@section('title', 'Pesanan & Pembayaran Saya — StrikeStore')
@section('meta_description', 'Daftar riwayat pesanan dan status pembayaran online Anda di StrikeStore.')

@section('content')
<div class="bg-white border-b border-slate-200 py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-emerald-700">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">Pesanan & Pembayaran Saya</span>
            </nav>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">
                Riwayat Pesanan & Pembayaran
            </h1>
        </div>
        <a href="{{ route('catalog.index') }}" class="px-4 py-2.5 rounded-xl bg-[#194668] hover:bg-emerald-700 text-white text-xs font-bold self-start sm:self-auto">
            + Belanja Lagi
        </a>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if ($orders->count() > 0)
        <div class="space-y-4">
            @foreach ($orders as $order)
                @php
                    $isPaid = $order->transaction?->status === 'paid';
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="font-mono font-extrabold text-sm text-slate-900">{{ $order->invoice_number }}</span>
                            <span class="text-xs text-slate-400">• {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                            @if ($isPaid)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    ✓ Lunas ({{ strtoupper($order->transaction->payment_method) }})
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                    Menunggu Pembayaran
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500">
                            Kurir: <strong class="text-slate-800">{{ $order->shipping_method }}</strong>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1 text-xs text-slate-600">
                            @foreach ($order->items as $item)
                                <div>
                                    <span class="font-bold text-slate-900">{{ $item->product_name }}</span>
                                    <span class="text-slate-400">({{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }})</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 shrink-0">
                            <div class="text-left sm:text-right">
                                <span class="text-[11px] text-slate-400 block">Total Tagihan</span>
                                <span class="font-heading font-extrabold text-lg text-emerald-900">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                @if (!$isPaid)
                                    <a 
                                        href="{{ route('checkout.payment', $order->invoice_number) }}" 
                                        class="px-4 py-2 rounded-xl bg-[#194668] hover:bg-emerald-700 text-white text-xs font-bold transition-colors"
                                    >
                                        Bayar Sekarang
                                    </a>
                                @endif
                                <a 
                                    href="{{ route('checkout.success', $order->invoice_number) }}" 
                                    class="px-3.5 py-2 rounded-xl border border-slate-300 hover:border-emerald-600 text-slate-700 hover:text-emerald-800 text-xs font-semibold transition-colors"
                                >
                                    Lihat Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">
            <h2 class="font-heading font-bold text-lg text-slate-900">Belum Ada Riwayat Pesanan</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-5">Anda belum memiliki transaksi pembelian. Yuk mulai pilih produk di katalog kami.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#194668] text-white text-xs font-bold">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

