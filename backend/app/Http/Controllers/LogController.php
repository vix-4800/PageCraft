<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\LogRetrievers\ApplicationLogRetriever;
use App\Services\LogRetrievers\QueueLogRetriever;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

final class LogController extends Controller
{
    private readonly QueueLogRetriever $queueLogRetriever;

    public function __construct(
        private readonly ApplicationLogRetriever $applicationLogRetriever,
    ) {
        $this->queueLogRetriever = new QueueLogRetriever('worker.log');
    }

    /**
     * Get latest logs.
     */
    public function getAppLogs(): JsonResponse
    {
        return ApiResponse::create($this->applicationLogRetriever->retrieve(), meta: [
            'total' => [
                'errors' => $this->applicationLogRetriever->getErrorLogsCount(),
            ],
        ]);
    }

    public function deleteAppLogs(): JsonResponse
    {
        Gate::authorize('manage-system');

        $this->applicationLogRetriever->clear();

        return ApiResponse::create();
    }

    public function getQueueLogs(): JsonResponse
    {
        return ApiResponse::create($this->queueLogRetriever->retrieve());
    }

    public function deleteQueueLogs(): JsonResponse
    {
        Gate::authorize('manage-system');

        $this->queueLogRetriever->clear();

        return ApiResponse::create();
    }
}
