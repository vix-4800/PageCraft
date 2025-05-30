<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderObserver;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property OrderStatus $status
 * @property float $sub_total
 * @property float $shipping
 * @property float $tax
 * @property float $total
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, OrderItem> $items
 * @property-read int|null $items_count
 * @property-read Collection<int, PromoCode> $promoCodes
 * @property-read int|null $promo_codes_count
 * @property-read User $user
 *
 * @method static OrderFactory factory($count = null, $state = [])
 * @method static Builder<static>|Order newModelQuery()
 * @method static Builder<static>|Order newQuery()
 * @method static Builder<static>|Order query()
 *
 * @mixin \Eloquent
 */
#[ObservedBy(OrderObserver::class)]
final class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'total',
        'sub_total',
        'shipping',
        'tax',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promoCodes(): BelongsToMany
    {
        return $this->belongsToMany(PromoCode::class);
    }

    public function applyPromoCode(PromoCode $promoCode): void
    {
        $this->total -= $promoCode->calculateDiscount($this->total);
        $this->save();

        $this->promoCodes()->attach($promoCode);

        $promoCode->increment('used_count');
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'total' => 'float',
            'sub_total' => 'float',
            'shipping' => 'float',
            'tax' => 'float',
        ];
    }
}
