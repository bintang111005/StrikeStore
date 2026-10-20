<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all()->keyBy('slug');
        }

        $products = [
            // JORAN (5 produk)
            [
                'category_slug' => 'joran',
                'name'          => 'Joran Shimano Bassterra EV Spinning 180cm',
                'sku'           => 'JRN-SHM-001',
                'description'   => 'Joran spinning Shimano Bassterra EV terbuat dari bahan carbon composite berkualitas tinggi. Sangat sensitif dan kuat untuk memancing ikan predator air tawar maupun muara.',
                'price'         => 850000,
                'discount_price'=> 799000,
                'stock'         => 15,
                'weight'        => 220,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'joran',
                'name'          => 'Joran Daiwa Crossfire 602MS 180cm',
                'sku'           => 'JRN-DW-002',
                'description'   => 'Joran spinning Daiwa Crossfire dengan material graphite blank yang ringan dan responsif, sangat nyaman digunakan pemancing pemula maupun menengah.',
                'price'         => 450000,
                'discount_price'=> null,
                'stock'         => 25,
                'weight'        => 185,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'joran',
                'name'          => 'Joran Maguro Extreme Mamba 165cm',
                'sku'           => 'JRN-MGR-003',
                'description'   => 'Joran galatama legendaris Maguro Extreme Mamba berbahan solid carbon, dilengkapi ring guide Fuji. Sangat tangguh menahan hentakan ikan mas dan patin monster.',
                'price'         => 320000,
                'discount_price'=> 285000,
                'stock'         => 30,
                'weight'        => 195,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'joran',
                'name'          => 'Joran Relix Nusantara Cangkek 682UL',
                'sku'           => 'JRN-RN-004',
                'description'   => 'Joran ultra light (UL) lokal premium dari Relix Nusantara. Memberikan sensasi strike maksimal untuk micro jig dan casting casting umpan ringan.',
                'price'         => 580000,
                'discount_price'=> null,
                'stock'         => 12,
                'weight'        => 98,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'joran',
                'name'          => 'Joran Pioneer Altitude Slow Jigging 190cm',
                'sku'           => 'JRN-PNR-005',
                'description'   => 'Joran laut khusus slow jigging dengan ring guide full Fuji K-Series. Dirancang khusus untuk menaklukkan predator laut dalam seperti kerapu dan tenggiri.',
                'price'         => 1150000,
                'discount_price'=> null,
                'stock'         => 8,
                'weight'        => 310,
                'status'        => 'active',
                'is_featured'   => false,
            ],

            // REEL (5 produk)
            [
                'category_slug' => 'reel',
                'name'          => 'Reel Shimano Sienna 2500 HG Spinning',
                'sku'           => 'REL-SHM-001',
                'description'   => 'Reel spinning Shimano Sienna dengan gear ratio 6.2:1 dan propulsion line management system. Putaran halus dan sangat awet untuk pemakaian harian.',
                'price'         => 520000,
                'discount_price'=> 475000,
                'stock'         => 20,
                'weight'        => 250,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'reel',
                'name'          => 'Reel Daiwa Revros LT 3000-CXH',
                'sku'           => 'REL-DW-002',
                'description'   => 'Reel konsep LT (Light & Tough) dari Daiwa dengan rotor Air Rotor dan ATD drag bertenaga. Sangat ringan namun kokoh untuk casting laut maupun tawar.',
                'price'         => 780000,
                'discount_price'=> null,
                'stock'         => 18,
                'weight'        => 240,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'reel',
                'name'          => 'Reel Ryobi Zeus HP 4000',
                'sku'           => 'REL-RYB-003',
                'description'   => 'Reel Ryobi Zeus bodi aluminium kuat dengan max drag 8kg. Pilihan ideal untuk mancing dasaran pantai, karang, maupun kolam galatama lele.',
                'price'         => 460000,
                'discount_price'=> 410000,
                'stock'         => 22,
                'weight'        => 295,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'reel',
                'name'          => 'Reel KastKing Spartacus II Baitcasting',
                'sku'           => 'REL-KST-004',
                'description'   => 'Reel baitcasting KastKing Spartacus II dengan dual brake system (sentrifugal & magnetik) dan 7+1 stainless bearing. Lemparan akurat dan bebas kusut (backlash).',
                'price'         => 650000,
                'discount_price'=> null,
                'stock'         => 14,
                'weight'        => 170,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'reel',
                'name'          => 'Reel Penn Battle III 5000 Heavy Duty',
                'sku'           => 'REL-PNN-005',
                'description'   => 'Reel spinning badak Penn Battle III dengan full metal body, CNC gear technology, dan HT-100 carbon fiber drag washers. Siap tempur di laut lepas.',
                'price'         => 1750000,
                'discount_price'=> 1590000,
                'stock'         => 7,
                'weight'        => 535,
                'status'        => 'active',
                'is_featured'   => true,
            ],

            // UMPAN (5 produk)
            [
                'category_slug' => 'umpan',
                'name'          => 'Umpan Rapala Countdown Elite 75mm Sinking',
                'sku'           => 'UMP-RPL-001',
                'description'   => 'Lure minnow sinking legendaris Rapala bodi kayu balsa premium. Gerakan renang realistis meniru ikan mangsa, sangat efektif untuk predator muara dan sungai.',
                'price'         => 165000,
                'discount_price'=> 145000,
                'stock'         => 40,
                'weight'        => 10,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'umpan',
                'name'          => 'Umpan Frog Soft Frog Lure 4cm 7g Anti Sangkut',
                'sku'           => 'UMP-FRG-002',
                'description'   => 'Umpan kodok tiruan karet lembut fleksibel dengan pelindung kail weedless. Paling ampuh untuk berburu ikan gabus dan toman di rawa atau perairan berlumut.',
                'price'         => 35000,
                'discount_price'=> null,
                'stock'         => 85,
                'weight'        => 7,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'umpan',
                'name'          => 'Umpan Metal Jig Storm Gomoku Koika 40g',
                'sku'           => 'UMP-STM-003',
                'description'   => 'Metal jig asimetris dengan gerakan fluttering atraktif saat jatuh bebas. Sangat disukai ikan kuwe, tongkol, dan pelagis laut lainnya.',
                'price'         => 75000,
                'discount_price'=> null,
                'stock'         => 50,
                'weight'        => 40,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'umpan',
                'name'          => 'Umpan Crankbait Megabass Griffon Zero Shallow',
                'sku'           => 'UMP-MGB-004',
                'description'   => 'Lure shallow crankbait premium asal Jepang dengan suara rattle nyaring yang memicu agresi ikan predator di air keruh maupun dangkal.',
                'price'         => 210000,
                'discount_price'=> 189000,
                'stock'         => 15,
                'weight'        => 14,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'umpan',
                'name'          => 'Umpan Pelet Bandul Galatama Stella 500g',
                'sku'           => 'UMP-STL-005',
                'description'   => 'Umpan bubuk pelet aroma wangi gurih amis berkualitas tinggi, diracik khusus untuk lomba pancing kolam galatama ikan mas, bawal, dan patin.',
                'price'         => 25000,
                'discount_price'=> null,
                'stock'         => 100,
                'weight'        => 500,
                'status'        => 'active',
                'is_featured'   => false,
            ],

            // SENAR (5 produk)
            [
                'category_slug' => 'senar',
                'name'          => 'Senar PE Relix Nusantara Jabrik X8 150m',
                'sku'           => 'SNR-RN-001',
                'description'   => 'Senar braided PE 8 strand buatan Indonesia dengan serat rapat halus dan lapisan coating licin. Menghasilkan lemparan jauh dan tahan abrasi tinggi.',
                'price'         => 135000,
                'discount_price'=> 120000,
                'stock'         => 45,
                'weight'        => 75,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'senar',
                'name'          => 'Senar Monofilament Daiwa Justron DPLS 500m',
                'sku'           => 'SNR-DW-002',
                'description'   => 'Senar nilon monofilamen Daiwa Justron 500 meter dengan kelenturan seimbang, memori rendah, dan kekuatan simpul andal untuk mancing harian.',
                'price'         => 65000,
                'discount_price'=> null,
                'stock'         => 70,
                'weight'        => 120,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'senar',
                'name'          => 'Senar Fluorocarbon Pioneer Leader 50m',
                'sku'           => 'SNR-PNR-003',
                'description'   => 'Senar shock leader 100% fluorocarbon dengan indeks refraksi mendekati air sehingga nyaris transparan. Sangat tahan gesekan karang dan gigi ikan tajam.',
                'price'         => 95000,
                'discount_price'=> null,
                'stock'         => 35,
                'weight'        => 60,
                'status'        => 'active',
                'is_featured'   => false,
            ],
            [
                'category_slug' => 'senar',
                'name'          => 'Senar PE Shimano Kairiki 8 300m Multi-Color',
                'sku'           => 'SNR-SHM-004',
                'description'   => 'Senar PE premium Jepang dengan metode anyaman VT Construction Method. Menghasilkan profil bulat sempurna, lembut, dan tingkat sensitivitas tinggi.',
                'price'         => 295000,
                'discount_price'=> 265000,
                'stock'         => 25,
                'weight'        => 110,
                'status'        => 'active',
                'is_featured'   => true,
            ],
            [
                'category_slug' => 'senar',
                'name'          => 'Senar Nilon Duraking Sinori 150m Soft',
                'sku'           => 'SNR-DRK-005',
                'description'   => 'Senar nilon extra lembut dengan kekuatan angkat beban tinggi. Cepat tenggelam dan minim lentur, pilihan pas untuk mancing pelampung dan dasaran.',
                'price'         => 45000,
                'discount_price'=> null,
                'stock'         => 60,
                'weight'        => 50,
                'status'        => 'active',
                'is_featured'   => false,
            ],
        ];

        foreach ($products as $item) {
            $categorySlug = $item['category_slug'];
            unset($item['category_slug']);

            $category = $categories->get($categorySlug);
            if (! $category) {
                continue;
            }

            $item['category_id'] = $category->id;
            $item['slug'] = Str::slug($item['name']);

            Product::updateOrCreate(
                ['sku' => $item['sku']],
                $item
            );
        }
    }
}
