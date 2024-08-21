<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ProjectService;
use App\Models\Project;
use App\Models\User;

class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $projectService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectService = new ProjectService();
    }

    public function testGetProjects()
    {
        $project = Project::factory()->create();

        $projects = $this->projectService->getProjects()->get();

        $this->assertTrue($projects->contains($project));
    }

    public function testGetProjectsByParameter()
    {
        $project = Project::factory()->create([
            'project_name' => 'Test Project',
            'project_description' => 'Description of Test Project',
            'deadline' => '2024-12-31'
        ]);

        $projects = $this->projectService->getProjectsByParameter('Test Project')->items();

        $this->assertContains($project->id, array_column($projects, 'id'));
    }

    public function testGetProjectById()
    {
        $project = Project::factory()->create();

        $retrievedProject = $this->projectService->getProjectById($project->id);

        $this->assertEquals($project->id, $retrievedProject->id);
    }

    public function testCreateProject()
    {
        $data = [
            'project_name' => 'New Project',
            'project_description' => 'New project description',
            'deadline' => '2024-12-31',
        ];

        $project = $this->projectService->createProject($data);

        $this->assertDatabaseHas('projects', [
            'project_name' => 'New Project',
        ]);
    }

    public function testUpdateProject()
    {
        $project = Project::factory()->create();

        $data = [
            'project_name' => 'Updated Project Name',
            'project_description' => 'Updated description',
            'deadline' => '2024-12-31',
        ];

        $updatedProject = $this->projectService->updateProject($project->id, $data);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'project_name' => 'Updated Project Name',
        ]);
    }

    public function testDeleteProject()
    {
        $project = Project::factory()->create();

        $this->projectService->deleteProject($project->id);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
