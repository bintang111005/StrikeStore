<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id', 'name', 'slug', 'description', 'price', 'discount_price',
    'stock', 'sku', 'weight', 'image', 'gallery', 'status', 'is_featured',
])]
class Product extends Model
{
    use SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'gallery' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get the category that owns this product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the effective price (discount or regular).
     */
    public function getEffectivePriceAttribute(): string
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Get discount percentage if available.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->discount_price && $this->discount_price < $this->price && $this->price > 0) {
            return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
        }

        return null;
    }

    /**
     * Detect brand from product name.
     */
    public function getBrandAttribute(): string
    {
        $brands = [
            'Shimano', 'Daiwa', 'Maguro', 'Relix Nusantara', 'Pioneer',
            'Ryobi', 'KastKing', 'Penn', 'Rapala', 'Megabass',
            'Duraking', 'Mustad', 'Versus', 'Storm', 'Stella',
        ];

        foreach ($brands as $brand) {
            if (stripos($this->name, $brand) !== false) {
                return $brand;
            }
        }

        return 'StrikeStore Pro';
    }

    /**
     * Deterministic realistic customer review rating.
     */
    public function getRatingScoreAttribute(): float
    {
        $ratings = [4.9, 4.8, 5.0, 4.7, 4.9, 4.8, 4.9, 5.0, 4.8, 4.7];

        return $ratings[$this->id % count($ratings)];
    }

    /**
     * Deterministic review count.
     */
    public function getReviewCountAttribute(): int
    {
        return 18 + (($this->id * 7) % 65);
    }

    /**
     * Get curated image URL with fallback based on product category & type.
     */
    public function getImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
                return $this->image;
            }

            return asset('storage/'.$this->image);
        }

        $categorySlug = $this->category?->slug ?? '';

        // Curated authentic photography for fishing items
        $photoMap = [
            'joran' => [
                'https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=800&q=80',
            ],
            'reel' => [
                'https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
            ],
            'umpan' => [
                'https://images.unsplash.com/photo-1616423640778-28d1b53229bd?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80',
            ],
            'senar' => [
                'https://images.unsplash.com/photo-1509114397022-ed747cca3f65?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
            ],
            'kail-aksesori' => [
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1582967788606-a171c1080cb0?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        $pool = $photoMap[$categorySlug] ?? $photoMap['joran'];

        return $pool[$this->id % count($pool)];
    }

    /**
     * Get image gallery for detail page.
     */
    public function getGalleryListAttribute(): array
    {
        if (! empty($this->gallery) && is_array($this->gallery) && count($this->gallery) > 0) {
            return $this->gallery;
        }

        $main = $this->image_url;
        $categorySlug = $this->category?->slug ?? '';

        $altPhotos = [
            'joran' => [
                'https://images.unsplash.com/photo-1544253331-a87f58b09bf2?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=1000&q=80',
            ],
            'reel' => [
                'https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1000&q=80',
            ],
            'umpan' => [
                'https://images.unsplash.com/photo-1616423640778-28d1b53229bd?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1000&q=80',
            ],
            'senar' => [
                'https://images.unsplash.com/photo-1509114397022-ed747cca3f65?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1000&q=80',
            ],
            'kail-aksesori' => [
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1582967788606-a171c1080cb0?auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1000&q=80',
            ],
        ];

        return array_unique(array_merge([$main], $altPhotos[$categorySlug] ?? [$main]));
    }
}
