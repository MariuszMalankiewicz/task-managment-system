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

    public function test_find_user_from_email_retured_user()
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
        ]);

        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
        ];

        $this->userRepository
            ->shouldReceive('findUserFromEmail')
            ->with($data['email'])
            ->once()
            ->andReturn(new User($user->toArray()));

        $response = $this->userService->findUserFromEmail($data['email']);

        $this->assertEquals($data['name'], $response->name);

        $this->assertEquals($data['email'], $response->email);
    }

    public function test_find_user_from_email_retured_null()
    {
        $email = 'test@test.com';

        $this->userRepository
            ->shouldReceive('findUserFromEmail')
            ->with($email)
            ->once()
            ->andReturn(new User());

        $response = $this->userService->findUserFromEmail($email);

        $this->assertEquals(null, $response->email);
    }

    public function test_find_user_from_id()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'test',
            'email' => 'test@test.com',
        ]);

        $data = [
            'id' => 1,
            'name' => 'test',
            'email' => 'test@test.com',
        ];

        $this->userRepository
            ->shouldReceive('findUserFromId')
            ->with($data['id'])
            ->once()
            ->andReturn(new User($user->toArray()));

        $response = $this->userService->findUserFromId($data['id']);

        $this->assertEquals($data['name'], $response->name);

        $this->assertEquals($data['email'], $response->email);
    }
}