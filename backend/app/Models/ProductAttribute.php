<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, ProductAttributeValue> $values
 * @property-read int|null $values_count
 *
 * @method static Builder<static>|ProductAttribute newModelQuery()
 * @method static Builder<static>|ProductAttribute newQuery()
 * @method static Builder<static>|ProductAttribute query()
 *
 * @mixin \Eloquent
 */
final class ProductAttribute extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
