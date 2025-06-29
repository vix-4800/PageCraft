<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserShowResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class UserController extends Controller
{
    public function index(): JsonResource
    {
        $limit = request()->get('limit', 10);

        return UserResource::collection(
            User::with('role')->paginate($limit)
        );
    }

    public function show(User $user): JsonResource
    {
        return new UserShowResource($user);
    }

    public function update(UpdateUserRequest $updateUserRequest, User $user): JsonResource
    {
        $validated = $updateUserRequest->validated();
        $validated = $updateUserRequest->safe()->only(['name', 'email', 'phone']);

        $user->update($validated);

        $role = Role::firstWhere('name', $updateUserRequest->role);
        $user->role()->associate($role);

        return new UserShowResource($user);
    }

    public function verify(User $user): JsonResource
    {
        $user->markEmailAsVerified();

        return new UserShowResource($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return ApiResponse::empty();
    }
}
