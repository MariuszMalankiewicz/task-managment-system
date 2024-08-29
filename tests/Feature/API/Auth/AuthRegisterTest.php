<?php

namespace Tests\Feature\API\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_register()
    {   
        $user = User::factory()->make()->makeVisible('password');

        $response = $this->postJson(route('user.registration', $user->toArray()));

        $response->assertCreated();

        $response->assertJson([
            'message' => 'rejestracja udana', 
            'data' => array(
                'name' => $user['name'], 
                'email' => $user['email'],
            ),
        ]);

        $this->assertDatabaseHas('users', [
            'name'=> $user['name'],
            'email'=> $user['email'],
            'password'=> $user['password']
        ]);
    }
}