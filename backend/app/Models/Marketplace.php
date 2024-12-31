<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $base_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MarketplaceAccount> $accounts
 * @property-read int|null $accounts_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereBaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereName($value)
 *
 * @mixin \Eloquent
 */
class Marketplace extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'base_url',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class);
    }
}
