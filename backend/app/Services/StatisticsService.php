<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

final class StatisticsService
{
    /**
     * @return array{
     *      total: int,
     *      today: int,
     *      this_week: int,
     *      this_month: int
     * }
     */
    public function getMetrics(Builder $builder, string $operation = 'count', string $column = '*'): array
    {
        return [
            'total' => $builder->{$operation}($column),
            'today' => $builder->where('created_at', '>=', today())->{$operation}($column),
            'this_week' => $builder->where('created_at', '>=', today()->subWeek())->{$operation}($column),
            'this_month' => $builder->where('created_at', '>=', today()->subMonth())->{$operation}($column),
        ];
    }

    /**
     * @return array<string, int>
     */
    public function getMetricsPerDay(Builder $builder, int $days = 7, string $operation = 'sum', string $column = 'total'): array
    {
        throw_unless(in_array($operation, ['sum', 'count', 'avg', 'max', 'min']), new InvalidArgumentException(sprintf('Operation %s is not valid.', $operation)));

        return $builder
            ->selectRaw(sprintf('DATE(created_at) as date, %s(%s) as total', $operation, $column))
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->oldest('date')
            ->pluck('total', 'date')
            ->toArray();
    }
}
