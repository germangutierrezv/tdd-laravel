<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
  /** @test */
  public function testRegister()
  {
    $data = [
      "email" => "test@mail.com",
      "name" => "Test",
      "password" => "secret1234",
      "password_confirmation" => "secret1234"
    ];

    $response = $this->json('POST', route('api.register'), $data);

    $response->assertStatus(201)
      ->dump();
  }
}
