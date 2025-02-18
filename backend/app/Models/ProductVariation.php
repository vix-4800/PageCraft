<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariationAttribute> $productVariationAttributes
 * @property-read int|null $product_variation_attributes_count
 *
 * @method static \Database\Factories\ProductVariationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariation query()
 *
 * @mixin \Eloquent
 */
class ProductVariation extends Model
{
    use HasFactory;

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

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
