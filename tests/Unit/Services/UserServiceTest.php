<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $userRepository;
    protected $userService;
    

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepository::class);

        $this->userService = new UserService($this->userRepository);
    }

    public function test_instance_user_service()
    {
        $this->assertInstanceOf(User::class, $this->userService);
    }

    public function test_create_user()
    {
        $data = [
            'name' => Str::random(4),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];

        $this->userRepository
            ->shouldReceive('createUser')
            ->with($data)
            ->once()
            ->andReturn(new User($data));

        $response = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $response);

        $this->assertEquals($data['name'], $response->name);

        $this->assertEquals($data['email'], $response->email);
    }
}