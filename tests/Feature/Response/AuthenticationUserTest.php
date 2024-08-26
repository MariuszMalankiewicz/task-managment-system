<?php

namespace Tests\Feature\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_successful_register_user()
    {   
        $user = User::factory()->make()->makeVisible('password');

        $response = $this->postJson(route('user.registration', $user->toArray()));

        $response->assertCreated();
        
        $response->assertJsonStructure([
                'message', 
                'data' => array('name', 'email', 'updated_at', 'created_at', 'id'),
            ]);
    }

    public function test_successful_login_user()
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

    public function test_not_found_user_cannot_login()
    {   
        $user = [
            'email' => 'test@test.com',
            'password' => 'password1234',
        ];

        $response = $this->postJson(route('user.login', $user));

        $response->assertNotFound();

        $response->assertJsonStructure([
            'message', 
            'data',
        ]);
    }

    public function test_successful_logout_user()
    {   
        $user = Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('user.logout', $user->toArray()));

        $response->assertOk();

        $response->assertJsonStructure([
            'message', 
            'data',
        ]);
    }

    public function test_unauthentication_user_cannot_logout()
    {   
        $user = User::factory()->create();

        $response = $this->postJson(route('user.logout', $user->toArray()));

        $response->assertUnauthorized();

        $response->assertJsonStructure([
            'message',
        ]);
    }
}