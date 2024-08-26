<?php

namespace Tests\Feature\Response;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_successful_register_user_and_check_returned_json_structure()
    {   
        $user = User::factory()->make()->makeVisible('password');

        $response = $this->postJson(route('user.registration', $user->toArray()));

        $response->assertCreated();
        
        $response->assertJsonStructure([
                'message', 
                'data' => array('name', 'email', 'updated_at', 'created_at', 'id'),
            ]);
    }

    public function test_successful_login_user_and_check_returned_json_structure()
    {   
        $user = Sanctum::actingAs(User::factory()->make()->makeVisible('password'));

        $response = $this->postJson(route('user.login', $user->toArray()));

        $response->assertOk();
    }
}