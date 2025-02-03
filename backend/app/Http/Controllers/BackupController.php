<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseBackupException;
use App\Helpers\ApiResponse;
use App\Helpers\DatabaseBackup;
use App\Services\DatabaseDumpers\DatabaseDumper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function __construct(
        private readonly DatabaseDumper $service
    ) {
        //
    }

    public function create(): Response
    {
        try {
            Artisan::call('backup:create');

            return ApiResponse::empty();
        } catch (DatabaseBackupException $th) {
            throw new ApiException($th->getMessage());
        }
    }

    public function restore(Request $request): Response
    {
        try {
            Artisan::queue('backup:restore', ['filename' => $request->input('filename')]);

            return ApiResponse::empty();
        } catch (DatabaseBackupException $th) {
            throw new ApiException($th->getMessage());
        }
    }

    public function list(): JsonResponse
    {
        return ApiResponse::create(
            collect($this->service->list()->map(fn (DatabaseBackup $backup): array => $backup->toArray()))
        );
    }

    public function delete(): Response
    {
        $this->service->deleteAll();

        return ApiResponse::empty();
    }
}
