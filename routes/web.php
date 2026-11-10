<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| StrikeStore Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Katalog Produk
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');

// 3. Halaman Kategori Produk
Route::get('/kategori/{category:slug}', [CatalogController::class, 'category'])->name('catalog.category');

// 4. Halaman Detail Produk
Route::get('/produk/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// 5. Halaman Keranjang Belanja & Checkout (Checkout wajib login)
Route::get('/keranjang', [CartController::class, 'page'])->name('cart.page');
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{invoiceNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Cart Interactivity (Session-Backed)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/toggle-select', [CartController::class, 'toggleSelect'])->name('toggle');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Existing Products Management CRUD
Route::resource('products', ProductController::class);
