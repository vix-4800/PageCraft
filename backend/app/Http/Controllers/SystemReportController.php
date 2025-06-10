<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\Server;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

final class SystemReportController extends Controller
{
    public function index(): JsonResponse
    {
        return ApiResponse::create([
            'is_database_up' => Server::isDatabaseUp(),
            'is_cache_up' => Server::isCacheUp(),
            'is_config_cached' => Server::isConfigCached(),
            'uptime' => Server::getUptime(),
        ]);
    }
}
