<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display the product catalog with search, filters, sorting, and pagination.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category')->where('status', '!=', 'inactive');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter (support slug or id)
        if ($categoryParam = $request->input('category')) {
            if (is_numeric($categoryParam)) {
                $query->where('category_id', $categoryParam);
            } else {
                $query->whereHas('category', function ($q) use ($categoryParam) {
                    $q->where('slug', $categoryParam);
                });
            }
        }

        // Brand filter
        if ($brand = $request->input('brand')) {
            $query->where('name', 'like', "%{$brand}%");
        }

        // Availability filter
        if ($request->input('availability') === 'in_stock') {
            $query->where('status', 'active')->where('stock', '>', 0);
        } elseif ($request->input('availability') === 'out_of_stock') {
            $query->where(function ($q) {
                $q->where('status', 'out_of_stock')->orWhere('stock', '<=', 0);
            });
        }

        // Price range filter
        if ($minPrice = $request->input('min_price')) {
            $query->whereRaw('COALESCE(discount_price, price) >= ?', [(float) $minPrice]);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->whereRaw('COALESCE(discount_price, price) <= ?', [(float) $maxPrice]);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'popular' => $query->orderByDesc('views_count'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('sort_order')
            ->get();

        $availableBrands = [
            'Shimano', 'Daiwa', 'Maguro', 'Relix Nusantara', 'Pioneer',
            'Ryobi', 'KastKing', 'Penn', 'Rapala', 'Megabass',
            'Duraking', 'Mustad', 'Versus',
        ];

        $totalCatalogCount = Product::where('status', '!=', 'inactive')->count();

        return view('catalog.index', compact(
            'products',
            'categories',
            'availableBrands',
            'totalCatalogCount',
            'sort'
        ));
    }

    /**
     * Display a specific category product listing.
     */
    public function category(Category $category, Request $request): View
    {
        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->where('status', '!=', 'inactive');

        // Search inside category
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Availability filter
        if ($request->input('availability') === 'in_stock') {
            $query->where('status', 'active')->where('stock', '>', 0);
        } elseif ($request->input('availability') === 'out_of_stock') {
            $query->where(function ($q) {
                $q->where('status', 'out_of_stock')->orWhere('stock', '<=', 0);
            });
        }

        // Price range filter
        if ($minPrice = $request->input('min_price')) {
            $query->whereRaw('COALESCE(discount_price, price) >= ?', [(float) $minPrice]);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->whereRaw('COALESCE(discount_price, price) <= ?', [(float) $maxPrice]);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $allCategories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('catalog.category', compact(
            'category',
            'products',
            'allCategories',
            'sort'
        ));
    }

    /**
     * Display product detail page with gallery and recommendations.
     */
    public function show(Product $product): View
    {
        $product->load('category');
        $product->increment('views_count');

        // Fetch 4 related products from the same category
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        // If not enough related products, backfill with featured products
        if ($relatedProducts->count() < 4) {
            $fillers = Product::with('category')
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->where('status', 'active')
                ->latest()
                ->take(4 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($fillers);
        }

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
