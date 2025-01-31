<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static Builder<static>|OneTimePassword active()
 * @method static Builder<static>|OneTimePassword newModelQuery()
 * @method static Builder<static>|OneTimePassword newQuery()
 * @method static Builder<static>|OneTimePassword query()
 * @method static Builder<static>|OneTimePassword whereCode($value)
 * @method static Builder<static>|OneTimePassword whereCreatedAt($value)
 * @method static Builder<static>|OneTimePassword whereExpiresAt($value)
 * @method static Builder<static>|OneTimePassword whereId($value)
 * @method static Builder<static>|OneTimePassword whereUpdatedAt($value)
 * @method static Builder<static>|OneTimePassword whereUserId($value)
 *
 * @mixin \Eloquent
 */
class OneTimePassword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('expires_at', '>', now());
    }
}
