<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
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

    public function test_create_user()
    {
        $user = [
            'name' => 'test',
            'email'=> 'test@test.com',
            'password'=> 'password1234',
        ];

        $this->userRepository->createUser($user);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }
}