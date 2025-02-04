<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseBackupException;
use App\Facades\Backup;
use App\Helpers\ApiResponse;
use App\Helpers\DatabaseBackup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
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
            Artisan::call('backup:restore', ['filename' => $request->input('filename')]);

            return ApiResponse::empty();
        } catch (DatabaseBackupException $th) {
            throw new ApiException($th->getMessage());
        }
    }

    public function list(): JsonResponse
    {
        return ApiResponse::create(
            Backup::listDatabaseBackups()->map(fn (DatabaseBackup $backup): array => $backup->toArray())
        );
    }

    public function delete(): Response
    {
        Backup::deleteAllDatabaseBackups();

        return ApiResponse::empty();
    }
}
