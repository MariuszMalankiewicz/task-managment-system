<?php

namespace Tests\Unit\Requests;
use App\Http\Requests\RegisterAuthRequest;
use Tests\TestCase;

class RegisterAuthRequestTest extends TestCase
{
    protected $request;
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RegisterAuthRequest();
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
}