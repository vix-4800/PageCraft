<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\VersionService;
use Illuminate\Http\JsonResponse;

class VersionController extends Controller
{
    public function __construct(
        private readonly VersionService $service
    ) {
        //
    }

    public function index(): JsonResponse
    {
        return ApiResponse::create([
            'latest' => $this->service->latest()->toArray(),
            'current' => $this->service->current(),
        ]);
    }
}
