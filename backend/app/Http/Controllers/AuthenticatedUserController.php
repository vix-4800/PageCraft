<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\UserAuthException;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResource
    {
        return UserShowResource::make($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request): JsonResource
    {
        $validated = $request->validated();

        if (! Hash::check($validated['password'], $request->user()->password)) {
            throw new UserAuthException('The provided password was incorrect', 422);
        }

        $request->user()->update($validated);

        return UserShowResource::make($request->user());
    }
}
