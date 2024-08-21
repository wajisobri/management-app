<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'project_name' => $this->faker->word,
            'project_description' => $this->faker->sentence,
            'deadline' => $this->faker->dateTime,
        ];
    }
}
