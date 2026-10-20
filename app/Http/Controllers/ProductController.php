<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        // Stats
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $outOfStock = Product::where('status', 'out_of_stock')->orWhere('stock', 0)->count();
        $featuredProducts = Product::where('is_featured', true)->count();

        return view('products.index', compact(
            'products', 'categories', 'totalProducts', 'activeProducts', 'outOfStock', 'featuredProducts'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'required|integer|min:0',
            'sku'            => 'nullable|string|max:100|unique:products,sku',
            'weight'         => 'nullable|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'         => 'required|in:active,inactive,out_of_stock',
            'is_featured'    => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan! 🎣');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('category');
        $product->increment('views_count');

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'required|integer|min:0',
            'sku'            => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'weight'         => 'nullable|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'         => 'required|in:active,inactive,out_of_stock',
            'is_featured'    => 'boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        // Update slug only if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui! ✅');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus! 🗑️');
    }
}
