<?php

namespace Tests\Feature\API\Tasks;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCreationValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $title;
    protected $description;
    protected $status;
    protected $user_id;
    
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $this->title = Str::random(10);
        $this->description = Str::random(50);
        $this->status = 'pending';
        $this->user_id = $this->user['id'];
    }

    public function test_title_is_required()
    {
        $task = [
            'title' => '',
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];

        $response = $this->postJson(route('tasks.store', $task));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'title'=> 'Tytuł jest wymagany.',
        ]);
    }

    public function test_description_is_required()
    {
        $task = [
            'title' => $this->title,
            'description' => '',
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];

        $response = $this->postJson(route('tasks.store', $task));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'description'=> 'Opis jest wymagany.',
        ]);
    }

    public function test_status_is_required()
    {
        $task = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => '',
            'user_id' => $this->user_id,
        ];

        $response = $this->postJson(route('tasks.store', $task));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'status'=> 'Status jest wymagany.',
        ]);
    }

    public function test_selected_status_is_invalid()
    {
        $task = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'invalid data',
            'user_id' => $this->user_id,
        ];

        $response = $this->postJson(route('tasks.store', $task));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'status'=> 'Wybrany status nie istnieje.',
        ]);
    }

    public function test_user_id_is_required()
    {
        $task = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => '',
        ];

        $response = $this->postJson(route('tasks.store', $task));

        $response->assertUnprocessable();

        $response->assertInvalid([
            'user_id'=> 'Identyfikacja użytkownika jest wymagana.',
        ]);
    }
}