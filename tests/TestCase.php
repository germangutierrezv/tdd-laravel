<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory as Faker;
use App\Models\User;
use DB;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication, RefreshDatabase;

  /**
   * Sets up the tests
   */
  public function setUp(): void
  {
    parent::setUp();

    $this->faker = Faker::create();

    Artisan::call('migrate'); // runs the migration

    // Enable foreign key support for SQLITE databases
    if (DB::connection() instanceof SQLiteConnection) {
      DB::statement(DB::raw('PRAGMA foreign_keys=on'));
    }

    $this->owner = User::factory()->create();
  }

  /**
   * Rolls back migrations
   */
  public function tearDown(): void
  {
    Artisan::call('migrate:rollback');

    parent::tearDown();
  }
}
