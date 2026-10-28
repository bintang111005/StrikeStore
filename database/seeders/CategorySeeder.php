<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed fishing product categories.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Joran Pancing',
                'slug' => 'joran',
                'description' => 'Joran pancing berkualitas untuk berbagai teknik memancing, dari casting hingga slow jigging.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Reel Pancing',
                'slug' => 'reel',
                'description' => 'Reel spinning, baitcasting, dan overhead berkekuatan tinggi untuk performa tarikan maksimal.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Umpan Pancing',
                'slug' => 'umpan',
                'description' => 'Umpan minnow, crankbait, frog lure, metal jig, dan pelet racikan pemikat predator.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Senar Pancing',
                'slug' => 'senar',
                'description' => 'Senar braided PE 8-strand, fluorocarbon shock leader, dan monofilament tahan gesekan.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Kail & Aksesori',
                'slug' => 'kail-aksesori',
                'description' => 'Kail pancing ultra-sharp, tackle box kompartemen, tang split ring, dan aksesori memancing.',
                'is_active' => true,
                'sort_order' => 5,
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
