<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the StrikeStore homepage.
     */
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        // Fallback if not enough featured products
        if ($featuredProducts->count() < 4) {
            $additionalProducts = Product::with('category')
                ->where('status', 'active')
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->latest()
                ->take(8 - $featuredProducts->count())
                ->get();
            $featuredProducts = $featuredProducts->concat($additionalProducts);
        }

        $newArrivals = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $totalActiveProducts = Product::where('status', 'active')->count();

        return view('home', compact(
            'categories',
            'featuredProducts',
            'newArrivals',
            'totalActiveProducts'
        ));
    }
}
