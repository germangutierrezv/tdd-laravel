<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class ProjectTest extends TestCase
{
  /**
   * @test
   */
  public function it_can_list_project_owned_by_used()
  {
    $project = $this->owner->projects()->create(
      Project::factory()->raw()
    );

    $response = $this->be($this->owner, 'api')
      ->getJson('/api/v1/projects');

    $response->assertStatus(200)
      ->assertJson([
        'data' => [
          $project->toArray()
        ]
      ]);
  }

  /**
   * @test
   */
  public function user_can_create_new_project()
  {
    $data = ['name' => 'Big App', 'owner_id' => $this->owner->id, 'description' => "Description"];

    $payload = Project::factory()->raw($data);

    $this->be($this->owner, 'api')
      ->postJson('/api/v1/projects', $payload)
      ->assertStatus(201);

    $this->assertDatabaseHas('projects', $data);
    $this->assertCount(1, $this->owner->projects);
  }

  /**
   * @test
   */
  public function a_project_must_have_name_and_description()
  {
    $payload = ['body' => 'without name and description'];

    $this->be($this->owner, 'api')
      ->postJson('/api/v1/projects', $payload)
      ->assertStatus(422)
      ->assertSee('The name field is required')
      ->assertSee('The description field is required');

    $this->assertDatabaseMissing('projects', $payload);
    $this->assertCount(0, $this->owner->projects);
  }

  /**
   * @test
   */
  public function it_can_view_a_single_project_with_tasks_in_it()
  {
    $project = $this->owner->projects()->create(
      Project::factory()->raw()
    );

    $project->addTask([
      'title' => 'Need to prepay hosting',
      'body' => 'something more info can go here about this task',
      'priority' => 1,
      'completed_at' => null,
      'user_id' => $this->owner->id
    ]);

    $this->be($this->owner, 'api')
      ->getJson('/api/v1/projects/' . $project->id)
      ->assertStatus(200)
      ->assertJson($project->load('tasks')->toArray());
  }

  /**
   * owner can update project
   *
   * @test
   */
  public function owner_can_update_project()
  {
    $project = $this->owner->projects()->create(
      Project::factory()->raw([
        'body' => 'body is cool',
        'name' => 'Project title'
      ])
    );

    $payload = [
      'body' => 'updated body with new option',
      'name' => 'Updated Project title'
    ];

    $this->be($this->owner, 'api')
      ->putJson('/api/v1/projects/' . $project->id, $payload)
      ->assertStatus(200)
      ->assertJson($payload);

    $this->assertEquals($payload['name'], $project->fresh()->name);
    $this->assertEquals($payload['body'], $project->fresh()->body);
  }

  /**
   * owner can delete a project with tasks in it
   *
   * @test
   */
  public function owner_can_delete_a_project_with_tasks_in_it()
  {
    $project = $this->owner->projects()->create(
      Project::factory()->raw()
    );

    $taskPayload = [
      'title' => 'Need to prepay hosting',
      'body' => 'something more info can go here about this task',
      'priority' => 1,
      'completed_at' => null,
      'user_id' => $this->owner->id
    ];

    $project->addTask($taskPayload);

    $this->be($this->owner, 'api')
      ->deleteJson('/api/v1/projects/' . $project->id)
      ->assertStatus(204);

    $this->assertDatabaseMissing('projects', $project->toArray());
    $this->assertDatabaseMissing('tasks', $taskPayload);
  }
}
