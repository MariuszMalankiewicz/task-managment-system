<?php

namespace Tests\Feature\API\Tasks;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $task = Task::factory()->make(['user_id' => $user['id']]);

        $response = $this->postJson(route('tasks.store'), $task->toArray());

        $response->assertCreated();

        $response->assertJson([
            'message' => 'zadanie stworzone',
            'data' => array(
                'title' => $task['title'],
                'description' => $task['description'],
                'status' => $task['status'],
                'user_id' => $task['user_id'],
            )
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => $task['title'],
            'description' => $task['description'],
            'status' => $task['status'],
            'user_id' => $task['user_id'],
        ]);
    }

    public function test_unauthenticated_user_cannot_create_task()
    {
        $user = User::factory()->create(['id' => 1]);

        $task = Task::factory()->make(['user_id' => $user['id']]);

        $response = $this->postJson(route('tasks.store'), $task->toArray());

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);

        $this->assertDatabaseMissing('tasks', [
            'title' => $task['title'],
            'description' => $task['description'],
            'status' => $task['status'],
            'user_id' => $task['user_id'],
        ]);
    }
}