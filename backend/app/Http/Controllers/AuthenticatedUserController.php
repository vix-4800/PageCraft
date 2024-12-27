<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UserShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResource
    {
        return new UserShowResource($request->user());
    }
}
