<?php

namespace Tests\Unit\ServiceProviders;
use Tests\TestCase;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class RepositoryServiceProviderTest extends TestCase
{
    protected $userService;
    protected $taskService;
    public function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserRepositoryInterface::class);   
        $this->taskService = $this->app->make(TaskRepositoryInterface::class);   
    }
    public function test_user_repository_bindings_are_registered()
    {
        $this->assertInstanceOf(UserRepository::class, $this->userService);
    }

    public function test_task_repository_bindings_are_registered()
    {
        $this->assertInstanceOf(TaskRepository::class, $this->taskService);
    }
}