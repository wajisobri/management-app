<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectFile>
 */
class ProjectFileFactory extends Factory
{
    protected $model = ProjectFile::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'file' => $this->faker->word . '.' . $this->faker->fileExtension,
            'mime_type' => $this->faker->mimeType
        ];
    }
}
