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
}