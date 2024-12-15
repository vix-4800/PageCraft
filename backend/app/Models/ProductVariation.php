<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $product_id
 * @property string $sku
 * @property string|null $image
 * @property float $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariationAttribute> $productVariationAttributes
 * @property-read int|null $product_variation_attributes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProductVariation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
        'image',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariationAttributes(): HasMany
    {
        return $this->hasMany(ProductVariationAttribute::class);
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn (int|float $value): float => round($value / 100, 2),
            set: fn (int|float $value): float|int => $value * 100,
        );
    }
}
