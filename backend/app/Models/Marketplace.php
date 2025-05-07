<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MarketplaceType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property MarketplaceType $name
 * @property string $base_url
 * @property-read Collection<int, MarketplaceAccount> $accounts
 * @property-read int|null $accounts_count
 *
 * @method static Builder<static>|Marketplace newModelQuery()
 * @method static Builder<static>|Marketplace newQuery()
 * @method static Builder<static>|Marketplace query()
 *
 * @mixin \Eloquent
 */
final class Marketplace extends Model
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

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => MarketplaceType::class,
        ];
    }
}
