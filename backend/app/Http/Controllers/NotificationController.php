<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function notifications(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return (new ApiResponse)->create($user->unreadNotifications()->get());
    }

    public function readNotification(Request $request, string $id): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        /** @var DatabaseNotification $notification */
        $notification = $user->unreadNotifications()->find($id);
        $notification->markAsRead();

        return (new ApiResponse)->create($user->unreadNotifications()->get());
    }

    public function readAllNotifications(Request $request): Response
    {
        $request->user()->unreadNotifications->markAsRead();

        return ApiResponse::empty();
    }
}
