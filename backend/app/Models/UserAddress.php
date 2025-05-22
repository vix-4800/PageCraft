<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\UserAddressObserver;
use Database\Factories\UserAddressFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property string|null $street
 * @property string|null $postal_code
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static UserAddressFactory factory($count = null, $state = [])
 * @method static Builder<static>|UserAddress newModelQuery()
 * @method static Builder<static>|UserAddress newQuery()
 * @method static Builder<static>|UserAddress query()
 *
 * @mixin \Eloquent
 */
#[ObservedBy(UserAddressObserver::class)]
final class UserAddress extends Model
{
    /** @use HasFactory<UserAddressFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }
}
