<?php

namespace Tests\Feature\API\Tasks;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_database_has_expected_columns()
    {
        $this->assertTrue( 
          Schema::hasColumns('tasks', [
            'id', 'title', 'description', 'status', 'user_id', 'created_at', 'updated_at',
        ]), 1);
    }
}