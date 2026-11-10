<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id', 'name', 'slug', 'description', 'price', 'discount_price',
    'stock', 'sku', 'weight', 'image', 'gallery', 'status', 'is_featured', 'views_count',
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

        return 'StrikeStore';
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
     * Get uploaded image URL, or null if no photo has been uploaded by the user.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
                return $this->image;
            }

            return asset('storage/'.$this->image);
        }

        return null;
    }

    /**
     * Get image gallery for detail page (only uploaded images, empty if none).
     */
    public function getGalleryListAttribute(): array
    {
        if (! empty($this->gallery) && is_array($this->gallery) && count($this->gallery) > 0) {
            return $this->gallery;
        }

        if ($this->image_url) {
            return [$this->image_url];
        }

        return [];
    }
}
