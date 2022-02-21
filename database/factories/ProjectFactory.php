<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Project>
 */
class ProjectFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Project::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->sentence(2),
      'description' => $this->faker->sentence(20),
      'body' => $this->faker->realText(),
      'color' => $this->faker->hexColor,
      'archived_at' => null,
      'owner_id' => function () {
        return User::factory()->create()->id;
      }
    ];
  }
}
