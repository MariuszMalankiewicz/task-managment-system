<?php

namespace Tests\Unit\Requests;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AuthenticationUserLoginRequest;

class AuthenticationUserLoginRequestTest extends TestCase
{
    protected $request;
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AuthenticationUserLoginRequest();
    }
    public function test_request_has_expected_rules()
    {
        $this->assertEquals(
            [
                'email' => 'required|email|max:255',
                'password' => 'required|min:8',
            ],
            $this->request->rules()
        );
    }

    public function test_request_passes_validation()
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
        ];

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_request_fails_validation()
    {
        $data = [
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $rules = $this->request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());

        $this->assertArrayHasKey('email', $validator->errors()->toArray());

        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}