<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $marketplace_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Marketplace $marketplace
 * @property-read Collection<int, MarketplaceAccountSetting> $settings
 * @property-read int|null $settings_count
 *
 * @method static Builder<static>|MarketplaceAccount newModelQuery()
 * @method static Builder<static>|MarketplaceAccount newQuery()
 * @method static Builder<static>|MarketplaceAccount query()
 *
 * @mixin \Eloquent
 */
final class MarketplaceAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'marketplace_id',
    ];

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(MarketplaceAccountSetting::class);
    }
}
