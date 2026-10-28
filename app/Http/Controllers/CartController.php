<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get current cart contents and summary.
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $request->session()->get('cart', []);
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'items' => array_values($cart),
            'count' => $totalItems,
            'subtotal' => $subtotal,
            'formatted' => 'Rp '.number_format($subtotal, 0, ',', '.'),
        ]);
    }

    /**
     * Add a product to cart.
     */
    public function add(Request $request): JsonResponse
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
            return response()->json([
                'success' => false,
                'message' => 'Maaf, stok produk ini sedang habis.',
            ], 422);
        }

        $cart = $request->session()->get('cart', []);
        $productId = $product->id;
        $effectivePrice = (float) ($product->discount_price ?? $product->price);

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok maksimal yang tersedia hanya {$product->stock} unit.",
                ], 422);
            }
            $cart[$productId]['quantity'] = $newQuantity;
            if ($variant) {
                $cart[$productId]['variant'] = $variant;
            }
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'price' => $effectivePrice,
                'category' => $product->category?->name ?? 'Peralatan',
                'image' => $product->image_url,
                'quantity' => $quantity,
                'variant' => $variant,
                'max_stock' => $product->stock,
            ];
        }

        $request->session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => "{$product->name} berhasil ditambahkan ke keranjang!",
            'count' => $totalItems,
            'subtotal' => $subtotal,
            'formatted' => 'Rp '.number_format($subtotal, 0, ',', '.'),
            'item' => $cart[$productId],
        ]);
    }

    /**
     * Update quantity of an item.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $cart = $request->session()->get('cart', []);
        $productId = $product->id;

        if (isset($cart[$productId])) {
            if ($validated['quantity'] > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tersedia hanya {$product->stock} unit.",
                ], 422);
            }
            $cart[$productId]['quantity'] = $validated['quantity'];
            $request->session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'count' => $totalItems,
            'subtotal' => $subtotal,
            'formatted' => 'Rp '.number_format($subtotal, 0, ',', '.'),
        ]);
    }

    /**
     * Remove an item from cart.
     */
    public function remove(Request $request, $productId): JsonResponse
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang.',
            'count' => $totalItems,
            'subtotal' => $subtotal,
            'formatted' => 'Rp '.number_format($subtotal, 0, ',', '.'),
        ]);
    }

    /**
     * Clear all cart items.
     */
    public function clear(Request $request): JsonResponse
    {
        $request->session()->forget('cart');

        return response()->json([
            'success' => true,
            'count' => 0,
            'subtotal' => 0,
            'formatted' => 'Rp 0',
        ]);
    }
}
