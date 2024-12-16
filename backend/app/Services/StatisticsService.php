<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class StatisticsService
{
    public function getMetrics(Builder $query, string $operation = 'count', string $column = '*'): array
    {
        return [
            'total' => $query->{$operation}($column),
            'today' => $query->whereDate('created_at', '>=', today())->{$operation}($column),
            'this_week' => $query->whereDate('created_at', '>=', today()->subWeek())->{$operation}($column),
            'this_month' => $query->whereDate('created_at', '>=', today()->subMonth())->{$operation}($column),
        ];
    }

    public function getMetricsPerDay(Builder $query, int $days = 7, string $operation = 'sum', string $column = 'total'): array
    {
        if (! in_array($operation, ['sum', 'count', 'avg', 'max', 'min'])) {
            throw new InvalidArgumentException("Operation {$operation} is not valid.");
        }

        return $query
            ->selectRaw("DATE(created_at) as date, $operation($column) as total")
            ->whereDate('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }
}
