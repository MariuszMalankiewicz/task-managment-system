<?php

namespace Tests\Unit\Auth;

use App\Http\Requests\LoginAuthRequest;
use Tests\TestCase;

class LoginAuthRequestTest extends TestCase
{
    protected $request;
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LoginAuthRequest();
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
}