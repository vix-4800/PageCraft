<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UserShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $user = $request->user();

        return UserShowResource::make($user);
    }
}
