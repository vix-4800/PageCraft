<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $cpu_usage
 * @property float $memory_usage
 * @property \Illuminate\Support\Carbon $collected_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric whereCollectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric whereCpuUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerformanceMetric whereMemoryUsage($value)
 *
 * @mixin \Eloquent
 */
class PerformanceMetric extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cpu_usage',
        'memory_usage',
        'collected_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cpu_usage' => 'float',
        'memory_usage' => 'float',
        'collected_at' => 'datetime',
    ];
}
