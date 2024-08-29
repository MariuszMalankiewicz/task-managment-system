<?php

namespace Tests\Feature\API\Tasks;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_featches_tasks_by_user_id()
    {
        $authUser = Sanctum::actingAs(User::factory()->create());

        $task = Task::factory()->create(['user_id' => $authUser->id]);

        $response = $this->getJson(route('tasks.index'));

        $response->assertOk();

        $response->assertJson([
            'data' => array([
                'title' => $task['title'],
                'description' => $task['description'],
                'status' => $task['status'],
                'user_id' => $task['user_id'],
                'id' => $task['id'],
                ])
        ]);
    }

    public function test_unauthenticated_user_cannot_featch_tasks_by_user_id()
    {
        $user = User::factory()->create();

        Task::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('tasks.index'));


        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}