<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\UserAuthException;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return UserShowResource::make($request->user())->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request): JsonResource
    {
        $validated = $request->validated();

        /** @var User|null $user */
        $user = $request->user();

        if (! Hash::check($validated['password'], $user->password)) {
            throw new UserAuthException('The provided password was incorrect', 422);
        }

        $user->update($validated);

        return UserShowResource::make($user);
    }
}
