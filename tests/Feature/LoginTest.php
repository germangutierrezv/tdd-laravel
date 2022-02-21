<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
  use DatabaseMigrations;

  /** @test*/
  public function it_visit_page_of_login()
  {
    $this->get('/login')
      ->assertStatus(200)
      ->assertSeeText('Log in');
    // ->assertSee('Log in');
  }
}
