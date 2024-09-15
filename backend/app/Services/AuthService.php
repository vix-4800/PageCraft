<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserRegistered;
use App\Exceptions\UserAuthException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    /**
     * Logs in a user.
     *
     * @param  array<string, string>  $credentials
     *
     * @throws UserAuthException
     */
    public function login(array $credentials): string
    {
        $user = User::whereEmail($credentials['email'])->first();

        throw_unless(
            $user && Hash::check($credentials['password'], $user->password),
            new UserAuthException('Invalid credentials', 422)
        );

        $user->tokens()->delete();

        return $user->createToken($user->email)->plainTextToken;
    }

    /**
     * Registers a new user and returns a token.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws UserAuthException
     */
    public function register(array $data): string
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::create($data);

            DB::commit();

            event(new UserRegistered($user));

            return $user->createToken($user->email)->plainTextToken;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UserAuthException('Registration failed, please try again', 500, $e);
        }
    }

    /**
     * Logs out the given user by deleting all their tokens.
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Verifies the email address of the given user.
     *
     * @return bool True if the email address was verified, false if it was already verified.
     */
    public function verify(User $user): bool
    {
        return $user->markEmailAsVerified();
    }
}
