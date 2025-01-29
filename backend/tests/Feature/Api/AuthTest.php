<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_register_with_invalid_data_fails(): void
    {
        $this->postJson(route('register.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => 'invalid-phone',
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

        $this->postJson(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_login_returns_error_when_credentials_are_invalid(): void
    {
        $this->postJson(route('login.store'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function test_login_succeeds(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $this->postJson(route('login.store'), [
            'email' => $user->email,
            'password' => $password,
        ])
            ->assertOk();
    }

    public function test_logout_returns_no_content_and_deletes_tokens(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('logout'))
            ->assertNoContent();
    }
}
