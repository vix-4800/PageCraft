<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseBackupException;
use App\Facades\Backup;
use App\Helpers\ApiResponse;
use App\Helpers\DatabaseBackup;
use App\Http\Requests\DatabaseBackupRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BackupController extends Controller
{
    public function create(): Response
    {
        try {
            Backup::createDatabaseBackup();

            return ApiResponse::empty();
        } catch (DatabaseBackupException $th) {
            throw new ApiException($th->getMessage());
        }
    }

    public function restore(DatabaseBackupRequest $request): Response
    {
        try {
            Backup::restoreDatabaseBackup($request->validated()['filename']);

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

    public function delete(DatabaseBackupRequest $request): Response
    {
        Backup::deleteDatabaseBackup($request->validated()['filename']);

        return ApiResponse::empty();
    }

    public function deleteAll(): Response
    {
        Backup::deleteAllDatabaseBackups();

        return ApiResponse::empty();
    }
}
