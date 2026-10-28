<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test homepage renders successfully.
     */
    public function test_homepage_returns_successful_response(): void
    {
        $category = Category::create([
            'name' => 'Joran Pancing',
            'slug' => 'joran',
            'description' => 'Joran berkualitas',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Joran Shimano Bassterra EV',
            'slug' => 'joran-shimano-bassterra-ev',
            'price' => 850000,
            'stock' => 10,
            'status' => 'active',
            'is_featured' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('StrikeStore');
        $response->assertSee('Gear Up. Cast Far.');
        $response->assertSee('Strike Big.');
    }

    /**
     * Test admin products management page renders successfully.
     */
    public function test_products_management_page_renders_successfully(): void
    {
        $category = Category::create([
            'name' => 'Joran Pancing',
            'slug' => 'joran-admin-test',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Joran Shimano Bassterra EV Admin',
            'slug' => 'joran-shimano-bassterra-ev-admin',
            'price' => 850000,
            'stock' => 10,
            'status' => 'active',
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Produk Pancing');
        $response->assertSee('Total Produk');
        $response->assertSee('Joran Shimano Bassterra EV Admin');
    }

    /**
     * Test catalog page renders successfully.
     */
    public function test_catalog_returns_successful_response(): void
    {
        $category = Category::create([
            'name' => 'Reel Pancing',
            'slug' => 'reel',
            'description' => 'Reel spinning',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Reel Daiwa Revros LT',
            'slug' => 'reel-daiwa-revros-lt',
            'price' => 780000,
            'stock' => 15,
            'status' => 'active',
        ]);

        $response = $this->get('/katalog');
        $response->assertStatus(200);
        $response->assertSee('All Fishing Gear');
        $response->assertSee('Reel Daiwa Revros LT');
    }

    /**
     * Test category page renders successfully.
     */
    public function test_category_page_returns_successful_response(): void
    {
        $category = Category::create([
            'name' => 'Umpan Pancing',
            'slug' => 'umpan',
            'description' => 'Lure minnow dan crankbait',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Umpan Rapala Countdown Elite',
            'slug' => 'umpan-rapala-countdown-elite',
            'price' => 165000,
            'stock' => 20,
            'status' => 'active',
        ]);

        $response = $this->get('/kategori/umpan');
        $response->assertStatus(200);
        $response->assertSee('Umpan Pancing');
        $response->assertSee('Umpan Rapala Countdown Elite');
    }

    /**
     * Test product detail page renders successfully.
     */
    public function test_product_detail_page_returns_successful_response(): void
    {
        $category = Category::create([
            'name' => 'Senar Pancing',
            'slug' => 'senar',
            'description' => 'Senar braided PE',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Senar PE Relix Nusantara Jabrik X8',
            'slug' => 'senar-pe-relix-nusantara-jabrik-x8',
            'description' => 'Senar braided PE 8 strand super halus',
            'price' => 135000,
            'discount_price' => 120000,
            'stock' => 30,
            'sku' => 'SNR-RN-001',
            'weight' => 75,
            'status' => 'active',
        ]);

        $response = $this->get('/produk/'.$product->slug);
        $response->assertStatus(200);
        $response->assertSee('Senar PE Relix Nusantara Jabrik X8');
        $response->assertSee('SNR-RN-001');
    }

    /**
     * Test cart add functionality.
     */
    public function test_cart_can_add_product(): void
    {
        $category = Category::create([
            'name' => 'Kail & Aksesori',
            'slug' => 'kail-aksesori',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Kail Mustad UltraPoint',
            'slug' => 'kail-mustad-ultrapoint',
            'price' => 45000,
            'stock' => 50,
            'status' => 'active',
        ]);

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'count' => 2,
        ]);
    }

    /**
     * Test cart add with variant support.
     */
    public function test_cart_can_add_product_with_variant(): void
    {
        $category = Category::create([
            'name' => 'Joran Pancing',
            'slug' => 'joran',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Joran Shimano Bassterra EV',
            'slug' => 'joran-shimano-bassterra-ev-test',
            'price' => 850000,
            'stock' => 10,
            'status' => 'active',
        ]);

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
            'variant' => '180cm / Medium Action',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'count' => 1,
            'item' => [
                'variant' => '180cm / Medium Action',
            ],
        ]);
    }

    /**
     * Test catalog search and brand filter.
     */
    public function test_catalog_search_and_brand_filter(): void
    {
        $category = Category::create([
            'name' => 'Reel Pancing',
            'slug' => 'reel',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Reel Shimano Stradic FL 3000',
            'slug' => 'reel-shimano-stradic-fl-3000',
            'price' => 2400000,
            'stock' => 5,
            'status' => 'active',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Reel Daiwa BG 4000',
            'slug' => 'reel-daiwa-bg-4000',
            'price' => 1300000,
            'stock' => 5,
            'status' => 'active',
        ]);

        $response = $this->get('/katalog?brand=Shimano');
        $response->assertStatus(200);
        $response->assertSee('Reel Shimano Stradic FL 3000');
        $response->assertDontSee('Reel Daiwa BG 4000');
    }

    /**
     * Test login page renders successfully.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk ke Akun');
        $response->assertSee('bintang@strikestore.id');
    }

    /**
     * Test user can login with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Bintang Angler',
            'email' => 'bintang.test@strikestore.id',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'bintang.test@strikestore.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user cannot login with incorrect password.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::create([
            'name' => 'Bintang Angler',
            'email' => 'bintang.test@strikestore.id',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'bintang.test@strikestore.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test user can register new account.
     */
    public function test_user_can_register_new_account(): void
    {
        $response = $this->post('/register', [
            'name' => 'Angler Baru',
            'email' => 'anglerbaru@strikestore.id',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'anglerbaru@strikestore.id',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Test authenticated user can logout.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Bintang Angler',
            'email' => 'bintang.test@strikestore.id',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
