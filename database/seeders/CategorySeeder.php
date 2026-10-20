<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed fishing product categories.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Joran',
                'slug'        => 'joran',
                'description' => 'Joran pancing berkualitas untuk berbagai teknik memancing, dari casting hingga jigging.',
                'is_active'   => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Reel',
                'slug'        => 'reel',
                'description' => 'Reel pancing spinning, baitcasting, dan overhead untuk performa maksimal.',
                'is_active'   => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Umpan',
                'slug'        => 'umpan',
                'description' => 'Umpan buatan (lure) dan umpan alami untuk berbagai jenis ikan target.',
                'is_active'   => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Senar',
                'slug'        => 'senar',
                'description' => 'Senar pancing monofilament, braided, dan fluorocarbon dengan berbagai ukuran.',
                'is_active'   => true,
                'sort_order'  => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
