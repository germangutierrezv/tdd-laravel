<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
  /**
   * task can be added to project
   *
   * @test
   */
  public function task_can_be_added_to_project()
  {
    $project = Project::factory()->create();

    $this->assertCount(0, $project->tasks);

    $project->addTask([
      'title' => 'Hello task',
      'body' => 'description is going here',
      'user_id' => 1
    ]);

    $this->assertCount(1, $project->fresh()->tasks);
  }
}
