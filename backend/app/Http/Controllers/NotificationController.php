<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notifications(Request $request): JsonResponse
    {
        return (new ApiResponse)->create(
            $request->user()->unreadNotifications()->get()->toArray()
        );
    }
}
