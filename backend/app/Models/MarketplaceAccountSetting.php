<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property int $marketplace_account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MarketplaceAccount|null $account
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereMarketplaceAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketplaceAccountSetting whereValue($value)
 *
 * @mixin \Eloquent
 */
class MarketplaceAccountSetting extends Model
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