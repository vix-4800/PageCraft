<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\VersionService;
use Illuminate\Http\JsonResponse;

final class VersionController extends Controller
{
    public function __construct(
        private readonly VersionService $versionService
    ) {
        //
    }

    public function index(): JsonResponse
    {
        return ApiResponse::create([
            'latest' => $this->versionService->latest()->toArray(),
            'current' => $this->versionService->current(),
        ]);
    }
}
