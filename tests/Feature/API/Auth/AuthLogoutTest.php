<?php

namespace Tests\Feature\API\Auth;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_logout_user()
    {   
        $user = Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('user.logout', $user->toArray()));

        $response->assertOk();

        $response->assertJson([
            'message' => 'poprawne wylogowanie',
            'data' => null,
        ]);
    }

    public function test_unauthentication_user_cannot_logout()
    {   
        $user = User::factory()->create();

        $response = $this->postJson(route('user.logout', $user->toArray()));

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}