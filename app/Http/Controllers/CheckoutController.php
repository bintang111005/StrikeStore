<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Available shipping methods and base costs.
     */
    public const SHIPPING_METHODS = [
        'jnt_cargo_pvc' => [
            'code' => 'jnt_cargo_pvc',
            'name' => 'J&T Cargo — Pipa PVC Aman',
            'description' => 'Packing pipa PVC paralon tebal + asuransi (Estimasi 2-4 hari)',
            'cost' => 25000,
            'free_eligible' => true,
            'badge' => 'Rekomendasi Joran',
        ],
        'sicepat_best' => [
            'code' => 'sicepat_best',
            'name' => 'SiCepat BEST Reguler',
            'description' => 'Bubble wrap tebal berlapis + kardus keras (Estimasi 1-3 hari)',
            'cost' => 20000,
            'free_eligible' => true,
            'badge' => 'Populer',
        ],
        'jne_yes' => [
            'code' => 'jne_yes',
            'name' => 'JNE YES — Kilat Esok Sampai',
            'description' => 'Layanan ekspres prioritas 1 hari sampai tujuan',
            'cost' => 35000,
            'free_eligible' => false,
            'badge' => 'Ekspres',
        ],
        'pickup_store' => [
            'code' => 'pickup_store',
            'name' => 'Ambil Langsung di Toko (StrikeStore Marina)',
            'description' => 'Ambil pesanan langsung di galeri StrikeStore Jakarta Utara',
            'cost' => 0,
            'free_eligible' => true,
            'badge' => 'Bebas Ongkir',
        ],
    ];

    /**
     * Available payment methods.
     */
    public const PAYMENT_METHODS = [
        'bank_transfer' => [
            'code' => 'bank_transfer',
            'name' => 'Transfer Bank / Virtual Account',
            'description' => 'BCA, Mandiri, BRI, BNI (Verifikasi otomatis)',
            'instructions' => 'Transfer ke Virtual Account BCA: 8801-0852-6378-5531 a/n StrikeStore Indonesia',
        ],
        'qris' => [
            'code' => 'qris',
            'name' => 'QRIS Instant All-Pay',
            'description' => 'Scan QR via GoPay, OVO, DANA, ShopeePay, atau Mobile Banking',
            'instructions' => 'Scan kode QRIS resmi StrikeStore menggunakan aplikasi pembayaran favorit Anda.',
        ],
        'e_wallet' => [
            'code' => 'e_wallet',
            'name' => 'E-Wallet (GoPay / DANA / ShopeePay)',
            'description' => 'Pembayaran praktis langsung dari dompet digital Anda',
            'instructions' => 'Kirim pembayaran E-Wallet ke nomor resmi StrikeStore: 0852-6378-5531.',
        ],
        'cod' => [
            'code' => 'cod',
            'name' => 'Bayar di Tempat (COD)',
            'description' => 'Bayar tunai langsung ke kurir saat pesanan tiba di alamat Anda',
            'instructions' => 'Siapkan uang tunai pas sesuai total tagihan saat kurir mengantarkan paket.',
        ],
    ];

    /**
     * Display the checkout form and product selection summary.
     */
    public function index(Request $request, CartController $cartController): View
    {
        $cart = $cartController->syncCartWithDatabase($request);

        // If no items are explicitly selected but cart has items, mark all as selected for convenience
        $selectedItems = array_filter($cart, fn ($item) => $item['selected'] ?? true);
        if (empty($selectedItems) && ! empty($cart)) {
            foreach ($cart as $id => $item) {
                $cart[$id]['selected'] = true;
            }
            $request->session()->put('cart', $cart);
        }

        $summary = $cartController->calculateCartSummary($cart);
        $selectedItems = array_values(array_filter($cart, fn ($item) => $item['selected'] ?? true));

        // Fetch catalog products so user can also pick/add products directly from the checkout page
        $availableProducts = Product::with('category')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(12)
            ->get();

        $user = Auth::user();

        return view('checkout.index', [
            'cartItems' => array_values($cart),
            'selectedItems' => $selectedItems,
            'summary' => $summary,
            'shippingMethods' => self::SHIPPING_METHODS,
            'paymentMethods' => self::PAYMENT_METHODS,
            'availableProducts' => $availableProducts,
            'user' => $user,
        ]);
    }

    /**
     * Process the checkout order and save to database.
     */
    public function store(Request $request, CartController $cartController): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'shipping_phone' => ['required', 'string', 'max:25'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_city' => ['nullable', 'string', 'max:100'],
            'shipping_province' => ['nullable', 'string', 'max:100'],
            'shipping_postal_code' => ['nullable', 'string', 'max:10'],
            'shipping_method' => ['required', 'string'],
            'payment_method' => ['required', 'in:bank_transfer,qris,e_wallet,cod,credit_card'],
            'notes' => ['nullable', 'string', 'max:500'],
            'promo_code' => ['nullable', 'string', 'max:50'],
        ], [
            'shipping_phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
            'shipping_address.required' => 'Alamat lengkap pengiriman wajib diisi.',
            'shipping_method.required' => 'Silakan pilih kurir pengiriman.',
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
        ]);

        $cart = $cartController->syncCartWithDatabase($request);
        $selectedItems = array_filter($cart, fn ($item) => $item['selected'] ?? true);

        if (empty($selectedItems)) {
            return redirect()->route('cart.page')
                ->with('error', 'Silakan pilih minimal 1 produk di keranjang belanja sebelum melakukan checkout.');
        }

        // Save updated phone & address to user profile for future checkouts
        if ($user) {
            $user->update([
                'phone' => $validated['shipping_phone'],
                'address' => $validated['shipping_address'],
            ]);
        }

        // Calculate subtotal & verify stock
        $subtotal = 0;
        foreach ($selectedItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Calculate shipping cost
        $shippingKey = $validated['shipping_method'];
        $shippingConfig = self::SHIPPING_METHODS[$shippingKey] ?? [
            'name' => $shippingKey,
            'cost' => 25000,
            'free_eligible' => true,
        ];

        $shippingCost = (float) $shippingConfig['cost'];
        if ($subtotal >= 500000) {
            if (! empty($shippingConfig['free_eligible'])) {
                $shippingCost = 0;
            } else {
                $shippingCost = max(0, $shippingCost - 20000);
            }
        }

        // Calculate promo discount
        $discount = 0;
        $promoCode = strtoupper(trim($validated['promo_code'] ?? ''));
        if ($promoCode === 'STRIKE50' && $subtotal >= 250000) {
            $discount = 50000;
        } elseif ($promoCode === 'HEMAT10') {
            $discount = min(100000, round($subtotal * 0.10));
        } elseif ($promoCode === 'ANGLER25') {
            $discount = 25000;
        }
        $discount = min($discount, $subtotal);

        $total = max(0, $subtotal + $shippingCost - $discount);

        $order = DB::transaction(function () use ($user, $validated, $selectedItems, $subtotal, $shippingCost, $discount, $total, $shippingConfig) {
            $invoiceNumber = 'INV-STRK-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));

            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'shipping_name' => $user->name,
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'] ?? ($user->city ?: '-'),
                'shipping_province' => $validated['shipping_province'] ?? ($user->province ?: '-'),
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? ($user->postal_code ?: '-'),
                'shipping_method' => $shippingConfig['name'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($selectedItems as $item) {
                $product = Product::lockForUpdate()->find($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'variant' => $item['variant'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                if ($product) {
                    $newStock = max(0, $product->stock - $item['quantity']);
                    $product->update([
                        'stock' => $newStock,
                        'status' => $newStock <= 0 ? 'out_of_stock' : $product->status,
                    ]);
                }
            }

            $paymentConfig = self::PAYMENT_METHODS[$validated['payment_method']] ?? self::PAYMENT_METHODS['bank_transfer'];

            Transaction::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'transaction_code' => 'TRX-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
                'amount' => $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'payment_details' => $paymentConfig['instructions'],
                'expired_at' => now()->addHours(24),
            ]);

            return $order;
        });

        // Remove only the checked-out items from the session cart
        foreach (array_keys($selectedItems) as $productId) {
            unset($cart[$productId]);
        }
        $request->session()->put('cart', $cart);

        // Store invoice in session so guest/member can easily view recent orders
        $recentOrders = $request->session()->get('recent_orders', []);
        array_unshift($recentOrders, $order->invoice_number);
        $request->session()->put('recent_orders', array_values(array_unique(array_slice($recentOrders, 0, 10))));

        return redirect()->route('checkout.success', $order->invoice_number)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran sesuai instruksi di bawah.');
    }

    /**
     * Display the order confirmation & invoice page.
     */
    public function success(string $invoiceNumber): View
    {
        $order = Order::with(['items.product', 'transaction'])
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();

        $paymentMethodKey = $order->transaction?->payment_method ?? 'bank_transfer';
        $paymentInfo = self::PAYMENT_METHODS[$paymentMethodKey] ?? self::PAYMENT_METHODS['bank_transfer'];

        return view('checkout.success', compact('order', 'paymentInfo'));
    }
}
