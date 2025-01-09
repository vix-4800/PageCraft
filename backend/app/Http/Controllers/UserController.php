<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserShowResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(): JsonResource
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user): JsonResource
    {
        return new UserShowResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResource
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['name', 'email', 'phone']);

        $user->update($validated);

        $role = Role::firstWhere('name', $request->role);
        $user->role()->associate($role);

        return new UserShowResource($user);
    }

    public function verify(User $user): JsonResource
    {
        $user->markEmailAsVerified();

        return new UserShowResource($user);
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }
}
