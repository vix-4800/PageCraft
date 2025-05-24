<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

final class StatisticsController extends Controller
{
    public function __construct(
        private readonly StatisticsService $statisticsService
    ) {
        //
    }

    public function overview(): JsonResponse
    {
        return ApiResponse::create([
            'users' => $this->statisticsService->getMetrics(User::query()),
            'sales' => $this->statisticsService->getMetrics(Order::query()),
            'earnings' => $this->statisticsService->getMetrics(Order::query(), 'sum', 'total'),
        ]);
    }

    public function salesForLastSevenDays(): JsonResponse
    {
        return ApiResponse::create(
            $this->statisticsService->getMetricsPerDay(Order::query(), 7, 'sum', 'total'),
        );
    }
}
