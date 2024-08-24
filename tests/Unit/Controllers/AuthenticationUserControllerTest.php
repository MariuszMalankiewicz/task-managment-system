<?php

namespace Tests\Unit\Controllers;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthenticationUserRegisterRequest;
use App\Http\Controllers\API\Authentication\AuthenticationUserController;

class AuthenticationUserControllerTest extends TestCase
{
    protected $userServiceMock;

    protected $authenticationUserRegisterRequestMock;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = Mockery::mock(UserService::class);

        $this->authenticationUserRegisterRequestMock = Mockery::mock(AuthenticationUserRegisterRequest::class);

        $this->controller = new AuthenticationUserController($this->userServiceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
    public function test_register_user()
    {
        $requestData = [
            'name' => Str::random(4),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];

        $this->authenticationUserRegisterRequestMock
            ->shouldReceive('validated')
            ->andReturn($requestData);

        $this->userServiceMock
            ->shouldReceive('createUser')
            ->with($requestData)
            ->andReturn((new User(['name' => $requestData['name'], 'email' => $requestData['email']])));

        $response = $this->controller->register($this->authenticationUserRegisterRequestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals($requestData['name'], $response->getData()->data->name);

        $this->assertEquals($requestData['email'], $response->getData()->data->email);
    }
}