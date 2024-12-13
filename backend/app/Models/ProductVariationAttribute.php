<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_variation_id
 * @property int $product_attribute_value_id
 * @property-read ProductAttributeValue $productAttributeValue
 * @property-read ProductVariation $productVariation
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute whereProductAttributeValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariationAttribute whereProductVariationId($value)
 *
 * @mixin \Eloquent
 */
class ProductVariationAttribute extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_variation_id',
        'product_attribute_value_id',
    ];

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function productAttributeValue(): BelongsTo
    {
        return $this->belongsTo(ProductAttributeValue::class);
    }
}
