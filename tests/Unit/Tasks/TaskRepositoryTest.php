<?php

namespace Tests\Unit\Tasks;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;
    protected $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = $this->app->make(TaskRepositoryInterface::class);
    }

    public function test_instance_task_repository()
    {
        $this->assertInstanceOf(TaskRepositoryInterface::class, $this->taskRepository);
    }

    public function test_create_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $task = [
            'title' => Str::random(10),
            'description' => Str::random(50),
            'status' => 'pending',
            'user_id' => $authUser['id'],
        ];

        $result = $this->taskRepository->createTask($task);

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

    public function test_find_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser['id']]);

        $result = $this->taskRepository->find($task->id);

        $this->assertEquals($task->id, $result->id);

        $this->assertEquals($task->title, $result->title);

        $this->assertEquals($task->description, $result->description);

        $this->assertEquals($task->status, $result->status);

        $this->assertEquals($task->user_id, $result->user_id);
    }

    public function test_update_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser['id']]);

        $data = [
            'title' => 'update title',
            'description' => 'update description',
        ];

        $result = $this->taskRepository->update($task, $data);

        $this->assertTrue($result);
    }
}