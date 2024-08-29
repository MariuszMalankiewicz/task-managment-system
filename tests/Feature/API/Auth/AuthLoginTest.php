<?php

namespace Tests\Feature\API\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_login()
    {   
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password1234', 
        ]);

        $user = [
            'email' => 'test@test.com',
            'password' => 'password1234',
        ];

        $response = $this->postJson(route('user.login', $user));

        $response->assertOk();

        $response->assertJsonStructure([
            'message', 
            'data' => array('access_token', 'token_type'),
        ]);
    }

    public function test_user_not_found_cannot_login()
    {   
        $user = [
            'email' => 'test@test.com',
            'password' => 'password1234',
        ];

        $response = $this->postJson(route('user.login', $user));

        $response->assertNotFound();

        $response->assertJson([
            'message' => 'email lub hasło jest nie poprawne', 
            'data' => null,
        ]);
    }
}