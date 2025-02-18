<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $marketplace_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Marketplace $marketplace
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MarketplaceAccountSetting> $settings
 * @property-read int|null $settings_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccount query()
 *
 * @mixin \Eloquent
 */
class MarketplaceAccount extends Model
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
