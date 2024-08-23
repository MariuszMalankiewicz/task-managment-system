<?php

namespace Tests\Unit\Requests;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\AuthenticationUserRegisterRequest;

class AuthenticationUserRegisterRequestTest extends TestCase
{
    protected $request;
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AuthenticationUserRegisterRequest();
    }
    public function test_request_has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => 'required|min:4|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
            ],
            $this->request->rules()
        );
    }

    public function test_request_passes_validation()
    {
        $data = [
            'name' => Str::random(4),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_request_fails_validation()
    {
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $rules = $this->request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}