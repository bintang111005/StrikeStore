# Penjelasan Fitur Keranjang Belanja & Checkout — StrikeStore

Dokumen ini menjelaskan struktur folder, lokasi file kodingan per halaman, serta alur kerja fitur **Keranjang Belanja dan Checkout** pada aplikasi Laravel **StrikeStore**.

---

## 1. Alur Singkat Sistem (Flowchart)

1. **Pilih Produk (`/katalog` atau `/produk/{slug}`)**  
   Pengguna memilih produk perlengkapan pancing (beserta varian & jumlah) lalu menekan tombol **+ Keranjang**. Data disimpan ke dalam `Session Cart` melalui `CartController@add`.
2. **Atur Keranjang Belanja (`/keranjang`)**  
   Pengguna melihat daftar produk di keranjang, mencentang produk yang ingin dibeli (`toggleSelect`), mengubah jumlah (`update`), atau menghapus produk (`remove`). Sistem menghitung subtotal, berat paket, dan syarat gratis ongkir secara *real-time*.
3. **Autentikasi Wajib (`/login` atau `/register`)**  
   Saat menekan tombol **Lanjut ke Data Pemesanan**, sistem memeriksa apakah pengguna sudah login (`middleware('auth')`). Jika belum, pengguna diarahkan untuk login atau membuat akun terlebih dahulu.
4. **Isi Data Pemesanan / Checkout (`/checkout`)**  
   - **Username / Nama Pemesan** otomatis terisi dari akun yang sedang login (`Auth::user()->name`) dan dikunci (`readonly`).
   - Pengguna cukup mengisi/mengubah **Nomor HP / WhatsApp** dan **Alamat Lengkap Pengiriman**, memilih **Kurir Ekspedisi**, memilih **Metode Pembayaran**, serta memasukkan **Kode Voucher** (opsional).
5. **Proses Pembayaran Online (`/pembayaran/{invoiceNumber}`)**  
   Setelah menekan **Buat Pesanan Sekarang**, pengguna diarahkan ke halaman Pembayaran Online yang menampilkan nomor Virtual Account BCA, kode QRIS, nomor E-Wallet (`0852-6378-5531`), atau instruksi COD. Pengguna dapat mengupload foto bukti bayar (opsional) lalu menekan tombol **Konfirmasi & Selesaikan Pembayaran Sekarang** (`CheckoutController@processPayment`), sehingga status transaksi berubah dari `pending` menjadi **`paid` (LUNAS)**.
6. **Bukti Transaksi & Invoice Lunas (`/checkout/success/{invoiceNumber}`)**  
   Menampilkan halaman **Invoice Resmi** berstatus **LUNAS** (lengkap dengan waktu pembayaran `paid_at` dan lampiran bukti bayar) yang bisa dicetak atau dikonfirmasi langsung ke WhatsApp Admin (`0852-6378-5531`), serta dapat dipantau kapan saja di halaman **Riwayat Pesanan & Pembayaran (`/pesanan-saya`)**.

---

## 2. Daftar Halaman & Lokasi File Kodingan

### A. Rute URL (Routing)
- **Lokasi File:** `routes/web.php`
- **Fungsi:** Menghubungkan URL di browser ke fungsi di dalam Controller.
  - `GET /keranjang` → `CartController@page` (Halaman Keranjang)
  - `POST /cart/add`, `/cart/update`, `/cart/toggle-select`, `DELETE /cart/remove/{id}` → `CartController` (Aksi AJAX Keranjang)
  - `GET /checkout` → `CheckoutController@index` (Halaman Form Checkout — wajib login)
  - `POST /checkout` → `CheckoutController@store` (Proses Simpan Pesanan — wajib login)
  - `GET /checkout/success/{invoiceNumber}` → `CheckoutController@success` (Halaman Invoice)

---

### B. Halaman 1: Katalog & Detail Produk (Memilih Produk)
- **File Tampilan (View):**
  - Katalog: `resources/views/catalog/index.blade.php`
  - Kategori: `resources/views/catalog/category.blade.php`
  - Detail Produk: `resources/views/catalog/show.blade.php`
  - Komponen Kartu Produk: `resources/views/components/product-card.blade.php`
  - Script Global `addToCart()`: `resources/views/layouts/app.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/CatalogController.php`
- **Penjelasan Singkat:**  
  Menampilkan daftar produk beserta fitur pencarian dan pengurutan (`Urutkan: Terbaru, Harga, Nama, Paling Banyak Dilihat`). Saat pengguna menekan tombol **+ Keranjang**, fungsi JavaScript `addToCart()` mengirim request ke `CartController@add` untuk memasukkan produk ke keranjang.

---

### C. Halaman 2: Keranjang Belanja (`/keranjang`)
- **File Tampilan (View):** `resources/views/cart/index.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/CartController.php`
- **Fungsi Utama di Controller:**
  - `page()` — Menampilkan halaman `/keranjang` beserta rekomendasi produk tambahan.
  - `add()` — Menambahkan produk & varian ke session keranjang.
  - `update()` — Mengubah jumlah kuantitas (`+` / `-`) atau varian produk.
  - `toggleSelect()` — Mencentang/melepas centang produk yang akan di-checkout.
  - `remove()` & `clear()` — Menghapus satu atau seluruh produk dari keranjang.
  - `syncCartWithDatabase()` & `calculateCartSummary()` — Mensinkronkan harga/stok terbaru dari database dan menghitung total harga item yang dicentang.

---

### D. Halaman 3: Login & Registrasi (`/login` & `/register`)
- **File Tampilan (View):**
  - Login: `resources/views/auth/login.blade.php`
  - Registrasi: `resources/views/auth/register.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/AuthController.php`
- **Penjelasan Singkat:**  
  Setiap pembeli yang ingin masuk ke halaman `/checkout` wajib login terlebih dahulu. Setelah berhasil login atau mendaftar akun baru (`redirect()->intended()`), pengguna otomatis diarahkan kembali ke halaman `/checkout` dan nama akunnya langsung terhubung.

---

### E. Halaman 4: Checkout & Data Pemesanan (`/checkout`)
- **File Tampilan (View):** `resources/views/checkout/index.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/CheckoutController.php` (method `index` dan `store`)
- **Penjelasan Singkat:**
  - `CheckoutController@index`: Mengambil daftar produk yang dicentang di keranjang serta data user yang sedang login (`Auth::user()`).
  - Pada tampilan `checkout/index.blade.php`:
    - **Username / Nama Pemesan** terisi otomatis dari `$user->name` dan bersifat `readonly`.
    - Pembeli hanya perlu mengisi/mengubah **Nomor HP / WhatsApp (`shipping_phone`)** dan **Alamat Lengkap Pengiriman (`shipping_address`)**, memilih kurir ekspedisi, dan memilih metode pembayaran.
  - `CheckoutController@store`: Memvalidasi input, menghitung ongkos kirim (otomatis gratis ongkir jika belanja ≥ Rp 500.000 pada kurir tertentu) dan potongan kode promo (`STRIKE50`, `HEMAT10`, `ANGLER25`), lalu menyimpan pesanan ke database menggunakan `DB::transaction()`.

---

### F. Halaman 5: Proses Pembayaran Online (`/pembayaran/{invoiceNumber}`)
- **File Tampilan (View):** `resources/views/checkout/payment.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/CheckoutController.php` (method `payment` dan `processPayment`)
- **Penjelasan Singkat:**  
  Menampilkan instruksi pembayaran interaktif (Virtual Account BCA, Scan Kode QRIS, E-Wallet `0852-6378-5531`, atau COD) beserta form upload bukti bayar (`payment_proof`). Saat pengguna menekan **Konfirmasi & Selesaikan Pembayaran Sekarang**, method `processPayment()` memperbarui status tabel `transactions` menjadi `paid` (Lunas), mencatat waktu `paid_at`, dan mengubah status `orders` menjadi `confirmed`.

---

### G. Halaman 6: Bukti Pemesanan / Invoice Lunas (`/checkout/success/{invoiceNumber}`) & Riwayat Pesanan (`/pesanan-saya`)
- **File Tampilan (View):**
  - Invoice: `resources/views/checkout/success.blade.php`
  - Riwayat Pesanan: `resources/views/checkout/orders.blade.php`
- **File Logika (Controller):** `app/Http/Controllers/CheckoutController.php` (method `success` dan `myOrders`)
- **Penjelasan Singkat:**  
  Menampilkan nomor invoice resmi (`INV-STRK-...`), status pembayaran (**LUNAS / BELUM DIBAYAR**), bukti transfer yang diupload, rincian alamat & ekspedisi, daftar barang yang dibeli, tombol **Cetak Invoice**, serta tombol **Konfirmasi via WhatsApp Admin** (`0852-6378-5531`).

---

## 3. Model & Tabel Database Terkait

| Nama Model | Lokasi File Model | Lokasi File Migrasi Database | Fungsi Tabel |
| :--- | :--- | :--- | :--- |
| **`Order`** | `app/Models/Order.php` | `database/migrations/2026_10_12_120003_create_orders_table.php` | Menyimpan data utama pesanan (nomor invoice, user_id, nama pemesan, no HP, alamat, kurir, subtotal, ongkir, diskon, dan total tagihan). |
| **`OrderItem`** | `app/Models/OrderItem.php` | `database/migrations/2026_11_10_093000_update_orders_for_checkout.php` | Menyimpan daftar produk yang dibeli di setiap pesanan (product_id, nama produk, varian, harga satuan, jumlah, subtotal). |
| **`Transaction`** | `app/Models/Transaction.php` | `database/migrations/2026_10_12_120004_create_transactions_table.php` | Menyimpan kode transaksi (`TRX-...`), metode pembayaran (`bank_transfer`, `qris`, `e_wallet`, `cod`), nominal, dan instruksi bayar. |
| **`Product`** | `app/Models/Product.php` | `database/migrations/2026_10_12_120002_create_products_table.php` | Menyimpan data produk, harga, diskon, stok (otomatis berkurang saat checkout), jumlah dilihat (`views_count`), dan foto produk. |
| **`User`** | `app/Models/User.php` | `database/migrations/0001_01_01_000000_create_users_table.php` | Menyimpan akun pembeli & admin (nama/username, email, password, no HP, dan alamat). |

