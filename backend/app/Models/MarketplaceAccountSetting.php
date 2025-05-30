<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property int $marketplace_account_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MarketplaceAccount|null $account
 *
 * @method static Builder<static>|MarketplaceAccountSetting newModelQuery()
 * @method static Builder<static>|MarketplaceAccountSetting newQuery()
 * @method static Builder<static>|MarketplaceAccountSetting query()
 *
 * @mixin \Eloquent
 */
final class MarketplaceAccountSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'marketplace_account_id',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(MarketplaceAccount::class);
    }
}
