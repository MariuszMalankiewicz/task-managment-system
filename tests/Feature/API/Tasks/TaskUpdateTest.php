<?php

namespace Tests\Feature\API\Tasks;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser->id]);

        $response = $this->putJson(route('tasks.update', $task->id), $task->toArray());

        $response->assertOk();

        $response->assertJson([
            'message' => 'zadanie zaktualizowane',
            'data' => array(
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'user_id' => $task->user_id,
            )
        ]);
    }

    public function test_task_for_update_dont_exists()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['id' => 2, 'user_id' => $authUser->id]);

        $wrongId = 1;

        $response = $this->putJson(route('tasks.update', $wrongId), $task->toArray());

        $response->assertNotFound();

        $response->assertJson([
            'message' => 'nie znaleziono zadania',
            'data' => null,
        ]);
    }

    public function test_unauthenticated_user_cannot_update_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson(route('tasks.update', $task->id), $task->toArray());

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}