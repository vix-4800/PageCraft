<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\User\UserShowResource;
use App\Notifications\AccountDeleted;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AuthenticatedUserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResource
    {
        return new UserShowResource($request->user());
    }

    public function destroy(Request $request): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->notify(new AccountDeleted);

        $user->tokens()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ApiResponse::empty();
    }
}
