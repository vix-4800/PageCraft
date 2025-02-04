<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PromoCodeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $code
 * @property PromoCodeType $type
 * @property float $value
 * @property float|null $min_order_amount
 * @property int|null $usage_limit
 * @property int $used_count
 * @property \Illuminate\Support\Carbon|null $valid_from
 * @property \Illuminate\Support\Carbon|null $valid_to
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read int|null $orders_count
 *
 * @method static \Database\Factories\PromoCodeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereMinOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereValidTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromoCode whereValue($value)
 *
 * @mixin \Eloquent
 */
class PromoCode extends Model
{
    /** @use HasFactory<\Database\Factories\PromoCodeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_to',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'type' => PromoCodeType::class,
        'value' => 'float',
        'min_order_amount' => 'float',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $now = now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_to && $now->gt($this->valid_to)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $total): float
    {
        if (! $this->isValid()) {
            throw new \Exception('Promo code is not valid.');
        }

        if ($this->min_order_amount && $total < $this->min_order_amount) {
            throw new \Exception('Order amount is less than the minimum required.');
        }

        return $this->type === PromoCodeType::PERCENTAGE
            ? $total * ($this->value / 100)
            : min($this->value, $total);
    }
}
