<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property string|null $street
 * @property string|null $postal_code
 * @property bool $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static \Database\Factories\UserAddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAddress whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserAddress extends Model
{
    /** @use HasFactory<\Database\Factories\UserAddressFactory> */
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
