<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CheckOAuthDriver;
use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Two\AbstractProvider;
use Socialite;

final class OAuthController extends Controller
{
    public function oauthRedirect(string $provider): JsonResponse
    {
        throw_unless(
            (new CheckOAuthDriver)->handle($provider),
            new ApiException('Invalid provider', 400)
        );

        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        $redirectUrl = $driver
            // ->with(['redirect_uri' => route('api.oauth.redirect', ['provider' => $provider])])
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return (new ApiResponse)->create([
            'url' => $redirectUrl,
        ]);
    }

    public function oauthCallback(Request $request, string $provider): JsonResponse
    {
        throw_unless(
            (new CheckOAuthDriver)->handle($provider),
            new ApiException('Invalid provider', 400)
        );

        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        $socialUser = $driver->with(['code' => $request['code']])
            ->stateless()
            ->user();

        return (new ApiResponse)->create([
            'user' => $socialUser,
        ]);
    }
}
