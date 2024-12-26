<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property array|null $additional_images
 * @property bool $is_archived
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductVariation> $variations
 * @property-read int|null $variations_count
 *
 * @method static Builder<static>|Product active()
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereAdditionalImages($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImage($value)
 * @method static Builder<static>|Product whereIsArchived($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product whereSlug($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'is_archived',
        'additional_images',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_archived' => 'boolean',
        'additional_images' => 'array',
    ];

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_archived', false);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->getKey(),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return ! $this->is_archived;
    }

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, ProductVariation::class);
    }
}
