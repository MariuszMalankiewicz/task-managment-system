<?php

namespace Tests\Feature\CRUD;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_successful_register_user_and_check_database_for_saved_user()
    {   
        $user = User::factory()->make()->makeVisible('password');

        $response = $this->postJson(route('user.registration', $user->toArray()));

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name'=> $user['name'],
            'email'=> $user['email'],
            'password'=> $user['password']
        ]);
    }
}