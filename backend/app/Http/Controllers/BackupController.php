<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseBackupException;
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
        try {
            $this->service->create();

            return ApiResponse::empty();
        } catch (DatabaseBackupException $th) {
            throw new ApiException($th->getMessage());
        }
    }

    public function list(): JsonResponse
    {
        return ApiResponse::create($this->service->list());
    }

    public function delete(): Response
    {
        $this->service->deleteAll();

        return ApiResponse::empty();
    }
}
