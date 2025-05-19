<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешной регистрации нового пользователя.
     */
    public function test_user_can_register_successfully()
    {
        $response = $this->post(route('user.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('verification.notice'));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Тест регистрации с некорректным подтверждением пароля.
     */
    public function test_user_cannot_register_with_invalid_password_confirmation()
    {
        $response = $this->post(route('user.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    /**
     * Тест успешной авторизации пользователя.
     */
    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(route('login.auth'), [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'Добро пожаловать, ' . $user->name . '!');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Тест авторизации с некорректным паролем.
     */
    public function test_user_cannot_login_with_invalid_password()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.auth'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email', 'Некорректный логин или пароль');
        $this->assertGuest();
    }

    /**
     * Тест выхода пользователя из системы.
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('logout'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /**
     * Тест отправки ссылки для сброса пароля.
     */
    public function test_user_can_request_password_reset_link()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post(route('password.email'), [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /**
     * Тест успешного сброса пароля.
     */
    public function test_user_can_reset_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword'),
        ]);

        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('newpassword123', User::where('email', 'test@example.com')->first()->password));
    }
}
