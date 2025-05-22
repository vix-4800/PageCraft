<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\SystemReportResource;
use App\Models\SystemReport;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

final class SystemReportController extends Controller
{
    public function index(): JsonResource
    {
        $orders = SystemReport::orderBy('collected_at', 'desc')->take(50)->get();

        return SystemReportResource::collection($orders->reverse());
    }

    public function refresh(): Response
    {
        Artisan::call('metrics:collect');

        return ApiResponse::empty();
    }
}
