<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\DatabaseBackupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BackupController extends Controller
{
    public function __construct(
        private readonly DatabaseBackupService $service
    ) {
        //
    }

    public function create(): Response
    {
        $this->service->create();

        return ApiResponse::empty();
    }

    public function list(): JsonResponse
    {
        return ApiResponse::create($this->service->list());
    }
}
