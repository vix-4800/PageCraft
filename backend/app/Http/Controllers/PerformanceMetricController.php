<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\PerformanceMetricResource;
use App\Models\PerformanceMetric;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class PerformanceMetricController extends Controller
{
    public function index(): JsonResource
    {
        return PerformanceMetricResource::collection(PerformanceMetric::take(50)->get());
    }

    public function refresh(): Response
    {
        Artisan::call('metrics:collect');

        return ApiResponse::empty();
    }
}
