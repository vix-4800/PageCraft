<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\SystemReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $cpu_usage
 * @property float $ram_usage
 * @property float $ram_total
 * @property float $network_incoming
 * @property float $network_outgoing
 * @property bool $is_database_up
 * @property bool $is_cache_up
 * @property string $uptime
 * @property \Illuminate\Support\Carbon $collected_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereCollectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereCpuUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereRamUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereRamTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereRamUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereNetworkIncoming($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereNetworkOutgoing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereIsDatabaseUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereIsCacheUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemReport whereUptime($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy(SystemReportObserver::class)]
class SystemReport extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cpu_usage',
        'ram_usage',
        'ram_total',
        'network_incoming',
        'network_outgoing',
        'is_database_up',
        'collected_at',
        'is_cache_up',
        'uptime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cpu_usage' => 'float',
        'ram_usage' => 'float',
        'ram_total' => 'float',
        'network_incoming' => 'float',
        'network_outgoing' => 'float',
        'is_database_up' => 'boolean',
        'is_cache_up' => 'boolean',
        'collected_at' => 'datetime',
    ];
}
