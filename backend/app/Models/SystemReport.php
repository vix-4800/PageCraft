<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\SystemReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property Carbon $collected_at
 *
 * @method static Builder<static>|SystemReport newModelQuery()
 * @method static Builder<static>|SystemReport newQuery()
 * @method static Builder<static>|SystemReport query()
 *
 * @mixin \Eloquent
 */
#[ObservedBy(SystemReportObserver::class)]
final class SystemReport extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_database_up',
        'is_cache_up',
        'uptime',
        'collected_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'is_database_up' => 'boolean',
        'is_cache_up' => 'boolean',
        'collected_at' => 'datetime',
    ];
}
