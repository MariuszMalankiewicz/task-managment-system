<?php

namespace Tests\Unit\ServiceProviders;
use Tests\TestCase;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryServiceProviderTest extends TestCase
{
    protected $service;
    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(UserRepositoryInterface::class);   
    }
    public function test_user_repository_bindings_are_registered()
    {
        $this->assertInstanceOf(UserRepository::class, $this->service);
    }
}