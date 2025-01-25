<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{
    public function notifications(Request $request): JsonResponse
    {
        return (new ApiResponse)->create($this->getUserNotifications($request->user()));
    }

    public function readNotification(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()->unreadNotifications->find($id);
        $notification->markAsRead();

        return (new ApiResponse)->create($this->getUserNotifications($request->user()));
    }

    private function getUserNotifications(User $user): Collection
    {
        return $user->unreadNotifications()->get();
    }
}
