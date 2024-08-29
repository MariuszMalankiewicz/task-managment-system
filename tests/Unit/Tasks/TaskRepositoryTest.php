<?php

namespace Tests\Unit\Tasks;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;
    protected $taskRepository;

    protected $user;
    
    protected $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = $this->app->make(TaskRepositoryInterface::class);

        $this->user = Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $this->task = [
            'title' => Str::random(10),
            'description' => Str::random(50),
            'status' => 'pending',
            'user_id' => $this->user['id'],
        ];
    }

    public function test_instance_task_repository()
    {
        $this->assertInstanceOf(TaskRepositoryInterface::class, $this->taskRepository);
    }

    public function test_create_task()
    {
        $response = $this->taskRepository->createTask($this->task);

        $this->assertEquals($this->task['title'], $response->title);

        $this->assertEquals($this->task['description'], $response->description);

        $this->assertEquals($this->task['status'], $response->status);

        $this->assertEquals($this->task['user_id'], $response->user_id);
    }
}