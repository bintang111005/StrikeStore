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
        $response->assertSee('Buat Akun Baru');
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

    /**
     * Test shopping cart page renders and displays selected products.
     */
    public function test_shopping_cart_page_renders_and_toggles_selection(): void
    {
        $category = Category::create([
            'name' => 'Joran Pancing',
            'slug' => 'joran',
            'is_active' => true,
        ]);

        $product1 = Product::create([
            'category_id' => $category->id,
            'name' => 'Joran Shimano Zodias',
            'slug' => 'joran-shimano-zodias',
            'price' => 300000,
            'stock' => 10,
            'status' => 'active',
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'name' => 'Reel Daiwa Tatula',
            'slug' => 'reel-daiwa-tatula',
            'price' => 400000,
            'stock' => 8,
            'status' => 'active',
        ]);

        $this->postJson('/cart/add', ['product_id' => $product1->id, 'quantity' => 1]);
        $this->postJson('/cart/add', ['product_id' => $product2->id, 'quantity' => 1]);

        $cartPage = $this->get('/keranjang');
        $cartPage->assertStatus(200);
        $cartPage->assertSee('Keranjang Belanja Anda');
        $cartPage->assertSee('Joran Shimano Zodias');
        $cartPage->assertSee('Reel Daiwa Tatula');

        // Unselect product 1
        $toggleResponse = $this->postJson('/cart/toggle-select', [
            'product_id' => $product1->id,
            'selected' => false,
        ]);

        $toggleResponse->assertStatus(200);
        $toggleResponse->assertJson([
            'success' => true,
            'selected_count' => 1,
            'subtotal' => 400000,
        ]);
    }

    /**
     * Test checkout requires login and uses authenticated user's name automatically.
     */
    public function test_checkout_page_and_order_submission(): void
    {
        $category = Category::create([
            'name' => 'Reel Pancing',
            'slug' => 'reel',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Reel Shimano Stella SW',
            'slug' => 'reel-shimano-stella-sw',
            'price' => 600000,
            'stock' => 5,
            'status' => 'active',
        ]);

        $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
            'variant' => 'Size 4000 Power',
        ]);

        // Guest should be redirected to login before accessing checkout
        $guestCheckout = $this->get('/checkout');
        $guestCheckout->assertRedirect('/login');

        // Authenticate user
        $user = User::create([
            'name' => 'Bintang Pratama',
            'email' => 'bintang.checkout@strikestore.id',
            'phone' => '081111111111',
            'address' => 'Alamat Lama',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $this->actingAs($user);

        $checkoutView = $this->get('/checkout');
        $checkoutView->assertStatus(200);
        $checkoutView->assertSee('Isi Data Pemesanan');
        $checkoutView->assertSee('Bintang Pratama');
        $checkoutView->assertSee('Reel Shimano Stella SW');

        $orderResponse = $this->post('/checkout', [
            'shipping_phone' => '085263785531',
            'shipping_address' => 'Jl. Samudra Strike No. 88, Marina, Jakarta Utara 14450',
            'shipping_method' => 'jnt_cargo_pvc',
            'payment_method' => 'qris',
            'promo_code' => 'STRIKE50',
            'notes' => 'Mohon packing pipa PVC tebal',
        ]);

        $orderResponse->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'shipping_name' => 'Bintang Pratama',
            'shipping_phone' => '085263785531',
            'shipping_address' => 'Jl. Samudra Strike No. 88, Marina, Jakarta Utara 14450',
            'subtotal' => 600000,
            'shipping_cost' => 0, // Free shipping >= 500k
            'discount' => 50000,  // STRIKE50 promo
            'total' => 550000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'product_name' => 'Reel Shimano Stella SW',
            'variant' => 'Size 4000 Power',
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas('transactions', [
            'payment_method' => 'qris',
            'amount' => 550000,
        ]);

        // Verify product stock was decremented
        $this->assertEquals(4, $product->fresh()->stock);
    }

    /**
     * Test all sorting options on catalog and category pages work accurately.
     */
    public function test_catalog_sorting_options_work_correctly(): void
    {
        $category = Category::create([
            'name' => 'Joran Pancing',
            'slug' => 'joran',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Alpha Rod',
            'slug' => 'alpha-rod',
            'price' => 500000,
            'stock' => 10,
            'views_count' => 10,
            'status' => 'active',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Charlie Rod',
            'slug' => 'charlie-rod',
            'price' => 150000,
            'stock' => 10,
            'views_count' => 100,
            'status' => 'active',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Bravo Rod',
            'slug' => 'bravo-rod',
            'price' => 900000,
            'stock' => 10,
            'views_count' => 50,
            'status' => 'active',
        ]);

        // 1. Produk Terbaru (latest -> newest ID first: Bravo, Charlie, Alpha)
        $this->get('/katalog?sort=latest')
            ->assertStatus(200)
            ->assertSeeInOrder(['Bravo Rod', 'Charlie Rod', 'Alpha Rod']);

        // 2. Harga: Terendah ke Tertinggi (price_asc -> Charlie 150k, Alpha 500k, Bravo 900k)
        $this->get('/katalog?sort=price_asc')
            ->assertStatus(200)
            ->assertSeeInOrder(['Charlie Rod', 'Alpha Rod', 'Bravo Rod']);

        // 3. Harga: Tertinggi ke Terendah (price_desc -> Bravo 900k, Alpha 500k, Charlie 150k)
        $this->get('/katalog?sort=price_desc')
            ->assertStatus(200)
            ->assertSeeInOrder(['Bravo Rod', 'Alpha Rod', 'Charlie Rod']);

        // 4. Nama: A - Z (name_asc -> Alpha, Bravo, Charlie)
        $this->get('/katalog?sort=name_asc')
            ->assertStatus(200)
            ->assertSeeInOrder(['Alpha Rod', 'Bravo Rod', 'Charlie Rod']);

        // 5. Paling Banyak Dilihat (popular -> Charlie 100, Bravo 50, Alpha 10)
        $this->get('/katalog?sort=popular')
            ->assertStatus(200)
            ->assertSeeInOrder(['Charlie Rod', 'Bravo Rod', 'Alpha Rod']);

        // Category page popular sort
        $this->get('/kategori/joran?sort=popular')
            ->assertStatus(200)
            ->assertSeeInOrder(['Charlie Rod', 'Bravo Rod', 'Alpha Rod']);
    }
}
