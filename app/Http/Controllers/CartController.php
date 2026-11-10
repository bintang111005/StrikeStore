<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the dedicated shopping cart page where users can select products and manage quantities.
     */
    public function page(Request $request): View
    {
        $cart = $this->syncCartWithDatabase($request);
        $summary = $this->calculateCartSummary($cart);

        // Provide active products so users can quickly select & add products directly from the cart page
        $quickProducts = Product::with('category')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(8)
            ->get();

        return view('cart.index', [
            'cartItems' => array_values($cart),
            'summary' => $summary,
            'quickProducts' => $quickProducts,
        ]);
    }

    /**
     * Get current cart contents and summary (JSON).
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $this->syncCartWithDatabase($request);
        $summary = $this->calculateCartSummary($cart);

        return response()->json([
            'items' => array_values($cart),
            'count' => $summary['total_items'],
            'selected_count' => $summary['selected_items'],
            'subtotal' => $summary['subtotal'],
            'formatted' => $summary['formatted_subtotal'],
        ]);
    }

    /**
     * Add a product to cart.
     */
    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:99',
            'variant' => 'nullable|string|max:100',
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $variant = $validated['variant'] ?? null;
        $product = Product::with('category')->findOrFail($validated['product_id']);

        if ($product->status === 'out_of_stock' || $product->stock <= 0) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, stok produk ini sedang habis.',
                ], 422);
            }

            return back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        $cart = $request->session()->get('cart', []);
        $productId = $product->id;
        $effectivePrice = (float) ($product->discount_price ?? $product->price);

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok maksimal yang tersedia hanya {$product->stock} unit.",
                    ], 422);
                }

                return back()->with('error', "Stok maksimal yang tersedia hanya {$product->stock} unit.");
            }
            $cart[$productId]['quantity'] = $newQuantity;
            $cart[$productId]['selected'] = true;
            if ($variant) {
                $cart[$productId]['variant'] = $variant;
            }
        } else {
            $defaultVariant = $variant ?? $this->getDefaultVariantForCategory($product->category?->slug ?? '');
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'price' => $effectivePrice,
                'original_price' => (float) $product->price,
                'category' => $product->category?->name ?? 'Peralatan',
                'category_slug' => $product->category?->slug ?? '',
                'image' => $product->image_url,
                'quantity' => $quantity,
                'variant' => $defaultVariant,
                'weight' => (float) ($product->weight ?? 250),
                'max_stock' => $product->stock,
                'selected' => true,
            ];
        }

        $request->session()->put('cart', $cart);
        $summary = $this->calculateCartSummary($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} berhasil ditambahkan ke keranjang!",
                'count' => $summary['total_items'],
                'selected_count' => $summary['selected_items'],
                'subtotal' => $summary['subtotal'],
                'formatted' => $summary['formatted_subtotal'],
                'item' => $cart[$productId],
            ]);
        }

        if ($request->boolean('redirect_checkout')) {
            return redirect()->route('checkout.index')->with('success', "{$product->name} siap untuk di-checkout!");
        }

        return back()->with('success', "{$product->name} berhasil ditambahkan ke keranjang!");
    }

    /**
     * Update quantity or variant of an item.
     */
    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant' => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $cart = $request->session()->get('cart', []);
        $productId = $product->id;

        if (isset($cart[$productId])) {
            if ($validated['quantity'] > $product->stock) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok tersedia hanya {$product->stock} unit.",
                    ], 422);
                }

                return back()->with('error', "Stok tersedia hanya {$product->stock} unit.");
            }
            $cart[$productId]['quantity'] = (int) $validated['quantity'];
            if (array_key_exists('variant', $validated) && $validated['variant'] !== null) {
                $cart[$productId]['variant'] = $validated['variant'];
            }
            $request->session()->put('cart', $cart);
        }

        $summary = $this->calculateCartSummary($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => $summary['total_items'],
                'selected_count' => $summary['selected_items'],
                'subtotal' => $summary['subtotal'],
                'formatted' => $summary['formatted_subtotal'],
                'summary' => $summary,
            ]);
        }

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Toggle product selection (single item or select all) for checkout.
     */
    public function toggleSelect(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'nullable|integer',
            'selected' => 'nullable|boolean',
            'select_all' => 'nullable|boolean',
        ]);

        $cart = $request->session()->get('cart', []);

        if ($request->has('select_all')) {
            $selectAll = (bool) $validated['select_all'];
            foreach ($cart as $id => $item) {
                $cart[$id]['selected'] = $selectAll;
            }
        } elseif (! empty($validated['product_id']) && isset($cart[$validated['product_id']])) {
            $pid = $validated['product_id'];
            $cart[$pid]['selected'] = isset($validated['selected'])
                ? (bool) $validated['selected']
                : ! ($cart[$pid]['selected'] ?? true);
        }

        $request->session()->put('cart', $cart);
        $summary = $this->calculateCartSummary($cart);

        return response()->json([
            'success' => true,
            'items' => array_values($cart),
            'count' => $summary['total_items'],
            'selected_count' => $summary['selected_items'],
            'subtotal' => $summary['subtotal'],
            'formatted' => $summary['formatted_subtotal'],
            'summary' => $summary,
        ]);
    }

    /**
     * Remove an item from cart.
     */
    public function remove(Request $request, $productId): JsonResponse|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
        }

        $summary = $this->calculateCartSummary($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang.',
                'count' => $summary['total_items'],
                'selected_count' => $summary['selected_items'],
                'subtotal' => $summary['subtotal'],
                'formatted' => $summary['formatted_subtotal'],
                'summary' => $summary,
            ]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * Clear all cart items.
     */
    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        $request->session()->forget('cart');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => 0,
                'selected_count' => 0,
                'subtotal' => 0,
                'formatted' => 'Rp 0',
            ]);
        }

        return back()->with('success', 'Keranjang belanja telah dikosongkan.');
    }

    /**
     * Synchronize session cart items with current database product attributes.
     */
    public function syncCartWithDatabase(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return [];
        }

        $products = Product::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');
        $updatedCart = [];

        foreach ($cart as $productId => $item) {
            if (! $products->has($productId)) {
                continue;
            }

            $product = $products->get($productId);
            $effectivePrice = (float) ($product->discount_price ?? $product->price);
            $qty = min((int) $item['quantity'], max(1, (int) $product->stock));

            $updatedCart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'price' => $effectivePrice,
                'original_price' => (float) $product->price,
                'category' => $product->category?->name ?? 'Peralatan',
                'category_slug' => $product->category?->slug ?? '',
                'image' => $product->image_url,
                'quantity' => $qty,
                'variant' => $item['variant'] ?? $this->getDefaultVariantForCategory($product->category?->slug ?? ''),
                'weight' => (float) ($product->weight ?? 250),
                'max_stock' => (int) $product->stock,
                'selected' => $item['selected'] ?? true,
            ];
        }

        $request->session()->put('cart', $updatedCart);

        return $updatedCart;
    }

    /**
     * Calculate cart summary for all items and selected items.
     */
    public function calculateCartSummary(array $cart): array
    {
        $totalItems = 0;
        $selectedItems = 0;
        $selectedProductsCount = 0;
        $subtotal = 0;
        $totalSavings = 0;
        $totalWeight = 0;

        foreach ($cart as $item) {
            $qty = (int) $item['quantity'];
            $totalItems += $qty;
            $isSelected = $item['selected'] ?? true;

            if ($isSelected) {
                $selectedItems += $qty;
                $selectedProductsCount++;
                $subtotal += $item['price'] * $qty;
                $totalWeight += ($item['weight'] ?? 250) * $qty;

                $origPrice = $item['original_price'] ?? $item['price'];
                if ($origPrice > $item['price']) {
                    $totalSavings += ($origPrice - $item['price']) * $qty;
                }
            }
        }

        $freeShippingThreshold = 500000;
        $isFreeShipping = $subtotal >= $freeShippingThreshold && $subtotal > 0;
        $remainingForFreeShipping = max(0, $freeShippingThreshold - $subtotal);
        $shippingProgress = $subtotal > 0 ? min(100, round(($subtotal / $freeShippingThreshold) * 100)) : 0;

        return [
            'total_items' => $totalItems,
            'selected_items' => $selectedItems,
            'selected_products_count' => $selectedProductsCount,
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp '.number_format($subtotal, 0, ',', '.'),
            'total_savings' => $totalSavings,
            'formatted_savings' => 'Rp '.number_format($totalSavings, 0, ',', '.'),
            'total_weight' => $totalWeight,
            'free_shipping_threshold' => $freeShippingThreshold,
            'is_free_shipping' => $isFreeShipping,
            'remaining_free_shipping' => $remainingForFreeShipping,
            'shipping_progress' => $shippingProgress,
        ];
    }

    /**
     * Default variant helper by category slug.
     */
    private function getDefaultVariantForCategory(string $catSlug): string
    {
        return match ($catSlug) {
            'joran' => '180cm / Medium Action',
            'reel' => 'Size 3000 CXH (Compact)',
            'umpan' => 'Ayu Natural (15g)',
            'senar' => 'PE 1.2 / 22 lbs (200m)',
            'kail-aksesori' => 'Size #2/0 (Isi 8)',
            default => 'Standar Original',
        };
    }
}
