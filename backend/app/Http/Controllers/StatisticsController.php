<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function index(): JsonResponse
    {
        return ApiResponse::create([
            'users' => [
                'total' => User::count(),
                'today' => User::where('created_at', '>=', now()->subDay())->count(),
                'this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
                'this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
            ],
            'sales' => [
                'total' => 0,
                'today' => 0,
                'this_week' => 0,
                'this_month' => 0
            ],
            'earnings' => [
                'total' => 0,
                'today' => 0,
                'this_week' => 0,
                'this_month' => 0
            ]
        ]);
    }
}
