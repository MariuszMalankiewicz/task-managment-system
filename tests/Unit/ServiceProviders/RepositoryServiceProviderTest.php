<?php

namespace Tests\Unit\ServiceProviders;
use Tests\TestCase;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_repository_bindings_are_registered()
    {
        $service = $this->app->make(UserRepositoryInterface::class);

        $this->assertInstanceOf(UserRepository::class, $service);
    }
}