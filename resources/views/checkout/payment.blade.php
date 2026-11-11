@extends('layouts.app')

@section('title', 'Pembayaran Pesanan ' . $order->invoice_number . ' — StrikeStore')
@section('meta_description', 'Selesaikan proses pembayaran online untuk pesanan perlengkapan memancing Anda di StrikeStore.')

@section('content')
{{-- Top Step Progress Header --}}
<div class="bg-white border-b border-slate-200/80 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('orders.my') }}" class="hover:text-emerald-700 transition-colors">Pesanan Saya</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Pembayaran Online</span>
                </nav>
                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Proses Pembayaran Online
                </h1>
            </div>

            {{-- Step Indicator --}}
            <div class="flex items-center gap-2 text-xs font-semibold">
                <span class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <span class="w-4 h-4 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px]">✓</span>
                    <span>Data Pemesanan</span>
                </span>
                <svg class="w-4 h-4 text-slate-300 shrink-0 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <div class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#194668] text-white shadow-sm">
                    <span class="w-5 h-5 rounded-full bg-emerald-400 text-slate-950 font-extrabold flex items-center justify-center text-[11px]">3</span>
                    <span>Pembayaran</span>
                </div>
                <svg class="w-4 h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400">
                    <span class="w-4 h-4 rounded-full bg-slate-200 text-slate-500 font-bold flex items-center justify-center text-[10px]">4</span>
                    <span>Selesai</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($order->transaction?->status === 'paid')
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold shrink-0">✓</span>
                <div class="text-xs sm:text-sm">
                    <strong class="block font-bold">Transaksi Ini Sudah Lunas!</strong>
                    <span>Pembayaran telah diterima pada {{ $order->transaction->paid_at?->format('d M Y, H:i') }} WIB.</span>
                </div>
            </div>
            <a href="{{ route('checkout.success', $order->invoice_number) }}" class="px-4 py-2 rounded-xl bg-[#194668] text-white text-xs font-bold shrink-0 text-center">
                Lihat Invoice Lunas →
            </a>
        </div>
    @endif

    <form action="{{ route('checkout.payment.process', $order->invoice_number) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- LEFT COLUMN: PAYMENT DETAILS & CONFIRMATION (2 cols) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- 1. PILIH METODE & INSTRUKSI PEMBAYARAN --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <h2 class="font-heading font-extrabold text-lg text-slate-900">1. Metode & Instruksi Pembayaran</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Selesaikan pembayaran sesuai metode yang Anda pilih di bawah ini</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->transaction?->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $order->transaction?->status === 'paid' ? '✓ LUNAS' : 'Menunggu Pembayaran' }}
                        </span>
                    </div>

                    {{-- Payment Method Selector Tabs --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        @foreach ($paymentMethods as $key => $pm)
                            @php
                                $isSelected = old('payment_method', $paymentMethodKey) === $key;
                            @endphp
                            <label class="pay-method-tab p-3 rounded-xl border-2 cursor-pointer transition-all text-center flex flex-col items-center justify-center gap-1 {{ $isSelected ? 'border-emerald-600 bg-emerald-50/50 text-emerald-900 font-bold' : 'border-slate-200 hover:border-slate-300 text-slate-700' }}">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="{{ $key }}" 
                                    {{ $isSelected ? 'checked' : '' }}
                                    onchange="switchPaymentInstruction(this.value)"
                                    class="sr-only"
                                />
                                <span class="text-xs font-heading font-bold">
                                    @if ($key === 'bank_transfer')
                                        Transfer Bank / VA
                                    @elseif ($key === 'qris')
                                        QRIS Instant
                                    @elseif ($key === 'e_wallet')
                                        E-Wallet
                                    @else
                                        COD (Bayar di Tempat)
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>

                    {{-- PANEL A: BANK TRANSFER / VIRTUAL ACCOUNT --}}
                    <div id="panel-bank_transfer" class="payment-instruction-panel p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4 {{ old('payment_method', $paymentMethodKey) === 'bank_transfer' ? '' : 'hidden' }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/80">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Bank Central Asia (BCA) / Virtual Account</span>
                                <div class="font-mono font-extrabold text-xl sm:text-2xl text-slate-900 tracking-wide mt-0.5" id="vaNumberText">
                                    8801 0852 6378 5531
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">a/n <strong>StrikeStore Indonesia</strong></p>
                            </div>
                            <button 
                                type="button" 
                                onclick="copyText('8801085263785531', 'Nomor Virtual Account disalin!')"
                                class="px-3.5 py-2 rounded-xl bg-white hover:bg-emerald-50 text-emerald-800 border border-slate-300 text-xs font-bold transition-colors self-start sm:self-center cursor-pointer"
                            >
                                Salin Nomor Rekening
                            </button>
                        </div>
                        <div class="text-xs text-slate-600 space-y-1">
                            <p class="font-bold text-slate-800">Cara Pembayaran Transfer / Virtual Account:</p>
                            <ol class="list-decimal list-inside space-y-1 text-slate-600">
                                <li>Buka aplikasi Mobile Banking (BCA / Mandiri / BRI / BNI) atau ATM.</li>
                                <li>Masukkan nomor Virtual Account <strong>8801085263785531</strong> di atas.</li>
                                <li>Pastikan nominal tagihan sesuai sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>.</li>
                                <li>Setelah membayar, klik tombol <strong>Konfirmasi & Selesaikan Pembayaran</strong> di bawah.</li>
                            </ol>
                        </div>
                    </div>

                    {{-- PANEL B: QRIS INSTANT --}}
                    <div id="panel-qris" class="payment-instruction-panel p-5 rounded-2xl bg-slate-50 border border-slate-200 {{ old('payment_method', $paymentMethodKey) === 'qris' ? '' : 'hidden' }}">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            {{-- QRIS Image Box --}}
                            <div class="p-3 bg-white rounded-2xl border-2 border-slate-200 shadow-xs text-center shrink-0">
                                <a href="{{ asset('images/qris-payment.jpg') }}" target="_blank" title="Klik untuk memperbesar kode QRIS">
                                    <img 
                                        src="{{ asset('images/qris-payment.jpg') }}" 
                                        alt="QRIS Pembayaran Biyzz (NMID: ID1026547298533)" 
                                        class="w-56 sm:w-64 h-auto mx-auto rounded-xl object-contain"
                                    />
                                </a>
                                <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between gap-2 px-1">
                                    <span class="text-[11px] font-bold text-slate-700">Biyzz (A01)</span>
                                    <a 
                                        href="{{ asset('images/qris-payment.jpg') }}" 
                                        download="QRIS-StrikeStore-Biyzz.jpg"
                                        class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 underline"
                                    >
                                        Unduh QRIS
                                    </a>
                                </div>
                            </div>

                            <div class="space-y-2.5 text-xs text-slate-600">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-bold text-[11px]">
                                        QRIS Standar Pembayaran Nasional
                                    </span>
                                    <span class="font-mono text-[11px] text-slate-500 font-semibold">
                                        NMID: ID1026547298533
                                    </span>
                                </div>
                                <h3 class="font-heading font-bold text-base text-slate-900">
                                    Scan QRIS (Biyzz) untuk Membayar Instan
                                </h3>
                                <p class="leading-relaxed">
                                    Mendukung pembayaran dari seluruh aplikasi berlogo QRIS: <strong>GoPay, OVO, DANA, ShopeePay, LinkAja, BCA Mobile, Livin' by Mandiri, BRImo, BNI Mobile,</strong> dan lainnya.
                                </p>
                                <ol class="list-decimal list-inside space-y-1 pt-1">
                                    <li>Buka aplikasi pembayaran berlogo QRIS di ponsel Anda.</li>
                                    <li>Scan kode QRIS <strong>Biyzz</strong> di samping (atau klik <strong>Unduh QRIS</strong>).</li>
                                    <li>Masukkan/pastikan nominal pembayaran sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>.</li>
                                    <li>Selesaikan pembayaran lalu klik tombol <strong>Konfirmasi & Selesaikan Pembayaran</strong> di bawah.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL C: E-WALLET --}}
                    <div id="panel-e_wallet" class="payment-instruction-panel p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 {{ old('payment_method', $paymentMethodKey) === 'e_wallet' ? '' : 'hidden' }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/80">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">GoPay / DANA / ShopeePay / OVO</span>
                                <div class="font-mono font-extrabold text-xl sm:text-2xl text-slate-900 mt-0.5">
                                    0852-6378-5531
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">a/n <strong>StrikeStore Admin</strong></p>
                            </div>
                            <button 
                                type="button" 
                                onclick="copyText('085263785531', 'Nomor E-Wallet berhasil disalin!')"
                                class="px-3.5 py-2 rounded-xl bg-white hover:bg-emerald-50 text-emerald-800 border border-slate-300 text-xs font-bold transition-colors self-start sm:self-center cursor-pointer"
                            >
                                Salin Nomor E-Wallet
                            </button>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Silakan kirim saldo sejumlah <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> ke nomor E-Wallet di atas, lalu tekan tombol <strong>Konfirmasi & Selesaikan Pembayaran</strong> di bawah.
                        </p>
                    </div>

                    {{-- PANEL D: COD --}}
                    <div id="panel-cod" class="payment-instruction-panel p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 {{ old('payment_method', $paymentMethodKey) === 'cod' ? '' : 'hidden' }}">
                        <div class="font-heading font-bold text-sm text-slate-900">
                            Bayar Tunai di Tempat (Cash on Delivery)
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Anda dapat membayar uang tunai sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> langsung kepada kurir saat paket perlengkapan pancing tiba di alamat Anda. Klik tombol konfirmasi di bawah untuk memproses pengiriman pesanan Anda.
                        </p>
                    </div>
                </div>

                {{-- 2. FORM KONFIRMASI & UPLOAD BUKTI PEMBAYARAN --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
                    <div class="pb-3 border-b border-slate-100">
                        <h2 class="font-heading font-extrabold text-lg text-slate-900">2. Konfirmasi Penyelesaian Pembayaran</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Lengkapi konfirmasi di bawah ini untuk mengubah status transaksi menjadi <strong>Lunas</strong></p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nama Pemesan / Pengirim
                            </label>
                            <input 
                                type="text" 
                                name="payer_name" 
                                value="{{ old('payer_name', $order->shipping_name) }}" 
                                readonly
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm font-semibold text-slate-600 cursor-not-allowed"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nominal Dibayarkan
                            </label>
                            <input 
                                type="text" 
                                value="Rp {{ number_format($order->total, 0, ',', '.') }}" 
                                readonly
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm font-extrabold text-emerald-800 cursor-not-allowed"
                            />
                        </div>
                    </div>

                    {{-- Upload Bukti Pembayaran --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Upload Bukti Transfer / Screenshot Pembayaran (Opsional)
                        </label>
                        <div class="border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-5 text-center cursor-pointer transition-colors bg-slate-50/60 relative">
                            <input 
                                type="file" 
                                name="payment_proof" 
                                accept="image/jpeg,image/png,image/webp" 
                                onchange="previewPaymentProof(this)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            />
                            <div class="space-y-1.5">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="font-bold text-emerald-700">Klik untuk pilih foto bukti bayar</span> (Struk / Screenshot M-Banking / QRIS)
                                </div>
                                <p class="text-[11px] text-slate-400">Format JPG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                        </div>

                        <div id="proofPreviewBox" class="hidden mt-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-200 text-center">
                            <img id="proofPreviewImg" class="max-h-44 mx-auto rounded-lg border border-slate-200 shadow-xs object-contain" />
                            <p class="text-[11px] text-emerald-700 font-bold mt-1.5">✓ Foto bukti pembayaran siap dikirim</p>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-4 px-6 rounded-xl font-heading font-bold text-sm bg-[#194668] hover:bg-emerald-700 text-white shadow-lg shadow-emerald-950/15 transition-all flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Konfirmasi & Selesaikan Pembayaran Sekarang</span>
                    </button>
                </div>

            </div>

            {{-- RIGHT COLUMN: ORDER & BILL SUMMARY (1 col) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs sticky top-28 space-y-4">
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Ringkasan Tagihan</span>
                        <div class="font-mono font-extrabold text-base text-slate-900 mt-0.5">{{ $order->invoice_number }}</div>
                        <div class="text-[11px] text-slate-500">Kode Transaksi: <span class="font-mono font-semibold text-slate-700">{{ $order->transaction?->transaction_code ?? '-' }}</span></div>
                    </div>

                    {{-- Penerima --}}
                    <div class="text-xs space-y-1 pb-3 border-b border-slate-100">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Pemesan:</span>
                            <span class="font-bold text-slate-900">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">No. HP / WA:</span>
                            <span class="font-semibold text-slate-800">{{ $order->shipping_phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kurir:</span>
                            <span class="font-semibold text-slate-800 text-right">{{ $order->shipping_method }}</span>
                        </div>
                    </div>

                    {{-- Item List --}}
                    <div class="space-y-2.5 max-h-60 overflow-y-auto pr-1 custom-scrollbar">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-slate-800 truncate">{{ $item->product_name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-slate-900 shrink-0">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total --}}
                    <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Ongkos Kirim</span>
                            <span>{{ $order->shipping_cost <= 0 ? 'GRATIS' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between text-emerald-700 font-semibold">
                                <span>Potongan Promo</span>
                                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="pt-2.5 border-t border-slate-200 flex items-center justify-between">
                            <span class="font-heading font-bold text-sm text-slate-900">Total Tagihan</span>
                            <span class="font-heading font-extrabold text-xl text-emerald-800">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-2 text-center">
                        <a href="{{ route('checkout.success', $order->invoice_number) }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-700 underline">
                            Lihat Detail Invoice Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function switchPaymentInstruction(method) {
        document.querySelectorAll('.payment-instruction-panel').forEach(el => el.classList.add('hidden'));
        const activePanel = document.getElementById('panel-' + method);
        if (activePanel) activePanel.classList.remove('hidden');

        document.querySelectorAll('.pay-method-tab').forEach(tab => {
            const radio = tab.querySelector('input[type="radio"]');
            if (radio && radio.value === method) {
                tab.classList.add('border-emerald-600', 'bg-emerald-50/50', 'text-emerald-900', 'font-bold');
                tab.classList.remove('border-slate-200', 'text-slate-700');
            } else {
                tab.classList.remove('border-emerald-600', 'bg-emerald-50/50', 'text-emerald-900', 'font-bold');
                tab.classList.add('border-slate-200', 'text-slate-700');
            }
        });
    }

    function copyText(value, message) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(value);
        }
        if (typeof showToast === 'function') {
            showToast('Berhasil Disalin', message);
        }
    }

    function previewPaymentProof(input) {
        const box = document.getElementById('proofPreviewBox');
        const img = document.getElementById('proofPreviewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection

