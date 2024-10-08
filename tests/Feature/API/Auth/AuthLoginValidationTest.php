<?php

namespace Tests\Feature\API\Auth;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthLoginValidationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_email_is_required()
    {
        $user = [
            'name' => Str::random(8),
            'email' => '',
            'password' => fake()->password(),
        ];

        $response = $this->postJson(route('user.registration', $user));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'email'=> 'Adres e-mail jest wymagany.',
        ]);
    }

    public function test_email_must_be_type_email()
    {
        $user = [
            'name' => Str::random(8),
            'email' => Str::random(8),
            'password' => fake()->password(),
        ];

        $response = $this->postJson(route('user.registration', $user));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'email'=> 'Adres e-mail musi być prawidłowym adresem e-mail.',
        ]);
    }

    public function test_email_must_have_a_maximum_of_255_characters()
    {
        $user = [
            'name' => Str::random(8),
            'email' => Str::random(255) . '@example.com',
            'password' => fake()->password(),
        ];

        $response = $this->postJson(route('user.registration', $user));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'email'=> 'Adres e-mail nie może mieć więcej niż 255 znaków.',
        ]);
    }

    public function test_password_is_required()
    {
        $user = [
            'name' => Str::random(8),
            'email' => fake()->unique()->safeEmail(),
            'password' => '',
        ];

        $response = $this->postJson(route('user.registration', $user));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'password'=> 'Hasło jest wymagane.',
        ]);
    }

    public function test_password_must_have_at_least_8_characters()
    {
        $user = [
            'name' => Str::random(4),
            'email' => fake()->unique()->safeEmail(),
            'password' => Str::random(4),
        ];

        $response = $this->postJson(route('user.registration', $user));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'password'=> 'Hasło musi mieć co najmniej 8 znaków.',
        ]);
    }
}