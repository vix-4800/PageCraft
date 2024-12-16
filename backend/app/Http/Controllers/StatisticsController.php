<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::create([
            'users' => [
                'total' => User::count(),
                'today' => User::where('created_at', '>=', now()->subDay())->count(),
                'this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
                'this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
            ],
            'sales' => [
                'total' => Order::count(),
                'today' => Order::where('created_at', '>=', now()->subDay())->count(),
                'this_week' => Order::where('created_at', '>=', now()->subWeek())->count(),
                'this_month' => Order::where('created_at', '>=', now()->subMonth())->count(),
            ],
            'earnings' => [
                'total' => Order::sum('total'),
                'today' => Order::where('created_at', '>=', now()->subDay())->sum('total'),
                'this_week' => Order::where('created_at', '>=', now()->subWeek())->sum('total'),
                'this_month' => Order::where('created_at', '>=', now()->subMonth())->sum('total'),
            ],
        ]);
    }
}
