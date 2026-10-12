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
}
