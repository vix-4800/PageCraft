<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::create([
            'users' => $this->getMetrics(User::query()),
            'sales' => $this->getMetrics(Order::query()),
            'earnings' => $this->getMetrics(Order::query(), 'sum', 'total'),
        ]);
    }

    private function getMetrics(Builder $query, string $operation = 'count', string $column = '*'): array
    {
        return [
            'total' => $query->{$operation}($column),
            'today' => $query->where('created_at', '>=', today())->{$operation}($column),
            'this_week' => $query->where('created_at', '>=', today()->subWeek())->{$operation}($column),
            'this_month' => $query->where('created_at', '>=', today()->subMonth())->{$operation}($column),
        ];
    }
}
