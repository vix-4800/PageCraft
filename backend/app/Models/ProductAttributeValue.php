<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $product_attribute_id
 * @property string $value
 * @property-read ProductAttribute $productAttribute
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariationAttribute> $productVariationAttributes
 * @property-read int|null $product_variation_attributes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue whereProductAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductAttributeValue whereValue($value)
 *
 * @mixin \Eloquent
 */
class ProductAttributeValue extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_attribute_id',
        'value',
    ];

    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    public function productVariationAttributes(): HasMany
    {
        return $this->hasMany(ProductVariationAttribute::class);
    }
}
