<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\VersionService;
use Illuminate\Http\JsonResponse;

class VersionController extends Controller
{
    private VersionService $service;

    public function __construct()
    {
        $this->service = new VersionService;
    }

    public function index(): JsonResponse
    {
        return ApiResponse::create([
            'latest' => $this->service->latest()->toArray(),
            'current' => $this->service->current(),
        ]);
    }
}
