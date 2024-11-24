<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(Request $request): JsonResource
    {
        return UserResource::collection(User::all());
    }

    public function view(Request $request): JsonResource
    {
        return UserShowResource::make($request->user());
    }
}
