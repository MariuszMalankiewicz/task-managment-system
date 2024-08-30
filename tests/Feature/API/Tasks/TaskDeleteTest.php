<?php

namespace Tests\Feature\API\Tasks;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_task()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser->id]);

        $response = $this->deleteJson(route('tasks.delete', $task->id));

        $response->assertNoContent();

        $this->assertDatabaseMissing('tasks', [
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'user_id' => $task->user_id,
            'id' => $task->id,
        ]);
    }

    public function test_task_for_delete_dont_exists()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser->id]);

        $wrongId = 2;

        $response = $this->deleteJson(route('tasks.delete', $wrongId));

        $response->assertNotFound();

        $response->assertJson([
            'message' => 'nie znaleziono zadania',
        ]);
    }

    public function test_unauthenticated_user_cannot_delete_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('tasks.delete', $task->id));

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}