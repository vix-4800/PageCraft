<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\LogRetrievers\ApplicationLogRetriever;
use App\Services\LogRetrievers\QueueLogRetriever;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class LogController extends Controller
{
    private QueueLogRetriever $queueLogs;

    public function __construct(
        private readonly ApplicationLogRetriever $appLogs,
    ) {
        $this->queueLogs = new QueueLogRetriever('worker.log');
    }

    /**
     * Get latest logs.
     */
    public function getAppLogs(): JsonResponse
    {
        return ApiResponse::create($this->appLogs->retrieve(), meta: [
            'total' => [
                'errors' => $this->appLogs->getErrorLogsCount(),
            ],
        ]);
    }

    public function deleteAppLogs(): JsonResponse
    {
        Gate::authorize('manage-system');

        $this->appLogs->clear();

        return ApiResponse::create();
    }

    public function getQueueLogs(): JsonResponse
    {
        return ApiResponse::create($this->queueLogs->retrieve());
    }

    public function deleteQueueLogs(): JsonResponse
    {
        Gate::authorize('manage-system');

        $this->queueLogs->clear();

        return ApiResponse::create();
    }
}
