<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
    }

    public function test_instance_user_repository()
    {
        $this->assertInstanceOf(UserRepositoryInterface::class, $this->userRepository);
    }

    public function test_create_user()
    {
        $user = [
            'name' => Str::random(4),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];

        $response = $this->userRepository->createUser($user);

        $this->assertInstanceOf(User::class, $response);

        $this->assertEquals($user['name'], $response->name);

        $this->assertEquals($user['email'], $response->email);
    }

    public function test_find_user_from_email_return_user()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);

        $email = 'test@test.com';

        $response = $this->userRepository->findUserFromEmail($email);

        $this->assertEquals($email, $response->email);
    }

    public function test_find_user_from_email_return_null()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);

        $email = 'otheremail@otheremail.com';

        $response = $this->userRepository->findUserFromEmail($email);

        $this->assertEquals(null, $response);
    }
}