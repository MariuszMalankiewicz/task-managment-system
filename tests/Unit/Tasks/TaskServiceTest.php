<?php

namespace Tests\Unit\Tasks;

use Mockery;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Services\TaskService;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $taskRepository;
    
    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = Mockery::mock(TaskRepository::class);

        $this->taskService = new TaskService($this->taskRepository);
    }

    public function test_create_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->make(['user_id' => $authUser['id']])->toArray();

        $this->taskRepository
            ->shouldReceive('createTask')
            ->with($task)
            ->andReturn(new Task($task));

        $result = $this->taskService->createTask($task);

        $this->assertEquals($task['title'], $result->title);

        $this->assertEquals($task['description'], $result->description);

        $this->assertEquals($task['status'], $result->status);

        $this->assertEquals($task['user_id'], $result->user_id);
    }

    public function test_get_tasks_from_user_id()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        Task::factory()->create(['user_id' => $authUser['id']]);

        $result = $this->taskRepository->getTasksFromUserId($authUser['id']);

        $this->assertCount(1, $result);
    }
}