<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Socialite;

class OAuthController extends Controller
{
    public function githubRedirect(): JsonResponse
    {
        return (new ApiResponse)->create([
            'url' => Socialite::driver('github')
                ->with(['redirect_uri' => route('api.auth.github.redirect')])
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function githubCallback(Request $request): JsonResponse
    {
        $socialUser = Socialite::driver(driver: 'github')
            ->with(['code' => $request['code']])
            ->stateless()
            ->user();

        return (new ApiResponse)->create([
            'user' => $socialUser,
        ]);
    }
}
