<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_register_with_invalid_data_fails(): void
    {
        $this->postJson(route('api.register'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_register_fails_when_email_is_taken(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->postJson(route('api.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_login_returns_error_when_credentials_are_invalid(): void
    {
        $this->postJson(route('api.login'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertUnprocessable()
            ->assertExactJson([
                'data' => [],
                'error' => true,
                'message' => 'Invalid credentials',
            ]);
    }

    public function test_login_returns_token_for_valid_user(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $this->postJson(route('api.login'), [
            'email' => $user->email,
            'password' => $password,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'token',
                ],
            ]);
    }

    public function test_logout_returns_no_content_and_deletes_tokens(): void
    {
        $user = User::factory()->create();
        $user->createToken($user->email);

        $this->assertTrue($user->tokens()->get()->count() === 1);

        $this->actingAs($user)
            ->postJson(route('api.logout'))
            ->assertNoContent();

        $this->assertTrue($user->tokens()->get()->count() === 0);
    }
}
