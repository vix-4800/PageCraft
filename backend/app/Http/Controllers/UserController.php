<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserShowResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(): JsonResource
    {
        return UserResource::collection(User::all());
    }

    public function view(User $user): JsonResource
    {
        return UserShowResource::make($user);
    }
}
