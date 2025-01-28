<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PerformanceMetricResource;
use App\Models\PerformanceMetric;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceMetricController extends Controller
{
    public function __invoke(): JsonResource
    {
        return PerformanceMetricResource::collection(PerformanceMetric::orderBy('collected_at', 'desc')->take(15)->get());
    }
}
