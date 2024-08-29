<?php

namespace Tests\Unit\Tasks;

use Tests\TestCase;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreTaskRequest;

class TaskCreationValidationTest extends TestCase
{
    protected $request;
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new StoreTaskRequest();
    }
    public function test_request_has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => 'required',
                'description' => 'required',
                'status' => [
                    'required',
                    Rule::in(['pending', 'in_progress', 'completed'])
                ],
                'user_id' => 'required'
            ],
            $this->request->rules()
        );
    }
}