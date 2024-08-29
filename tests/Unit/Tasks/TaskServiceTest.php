<?php

namespace Tests\Unit\Tasks;

use Mockery;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use App\Services\TaskService;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $taskRepository;
    
    protected $taskService;
    
    protected $user;

    protected $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = Mockery::mock(TaskRepository::class);

        $this->taskService = new TaskService($this->taskRepository);
        
        $this->user = Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $this->task = [
            'title' => Str::random(10),
            'description' => Str::random(50),
            'status' => 'pending',
            'user_id' => $this->user['id'],
        ];
    }

    public function test_create_task()
    {
        $this->taskRepository
            ->shouldReceive('createTask')
            ->with($this->task)
            ->andReturn(new Task($this->task));

        $response = $this->taskService->createTask($this->task);

        $this->assertEquals($this->task['title'], $response->title);

        $this->assertEquals($this->task['description'], $response->description);

        $this->assertEquals($this->task['status'], $response->status);

        $this->assertEquals($this->task['user_id'], $response->user_id);
    }
}