<?php

namespace Tests\Feature\API\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue( 
          Schema::hasColumns('users', [
            'id', 'name', 'email', 'password', 'created_at', 'updated_at',
        ]), 1);
    }
}
