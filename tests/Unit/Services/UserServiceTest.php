<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
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
    public function test_create_user()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test1234',
        ];

        $this->userRepository
            ->shouldReceive('createUser')
            ->with($data)
            ->once()
            ->andReturn(new User($data));

        $user = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('test', $user->name);
    }
}