<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ProjectFileService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProjectFileServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $projectFileService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectFileService = new ProjectFileService();
        Storage::fake('public'); // Fake storage for testing
    }

    public function testGetProjectFileStatistics()
    {
        $project = Project::factory()->create();
        $projectFile1 = ProjectFile::factory()->create([
            'project_id' => $project->id,
            'mime_type' => 'application/pdf',
        ]);
        $projectFile2 = ProjectFile::factory()->create([
            'project_id' => $project->id,
            'mime_type' => 'image/jpeg',
        ]);

        $statistics = $this->projectFileService->getProjectFileStatistics($project->id);

        $this->assertEquals(1, $statistics['totalDocuments']);
        $this->assertEquals(1, $statistics['totalImages']);
        $this->assertEquals(0, $statistics['totalVideos']);
        $this->assertEquals(0, $statistics['totalAudios']);
        $this->assertEquals(50, $statistics['pctDocuments']); // 1 out of 2
        $this->assertEquals(50, $statistics['pctImages']); // 1 out of 2
    }

    public function testStoreFiles()
    {
        $project = Project::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg');

        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $request = new Request();
        $request->merge(['id' => $project->id]);
        $request->files->set('file', [$file]);

        $this->projectFileService->storeFiles($request);
        $this->assertDatabaseHas('project_files', [
            'project_id' => $project->id,
            'file' => 'photo.jpg',
        ]);

        Storage::disk('public')->assertExists('projects/' . $project->id . '/photo.jpg');
    }

    public function testDeleteFile()
    {
        $project = Project::factory()->create();
        $projectFile = ProjectFile::factory()->create([
            'project_id' => $project->id,
            'file' => 'photo.jpg',
            'mime_type' => 'image/jpeg',
        ]);

        // Fake the file storage
        Storage::disk('public')->put('projects/' . $project->id . '/photo.jpg', 'file content');

        $this->projectFileService->deleteFile($project->id, $projectFile->id);

        $this->assertDatabaseMissing('project_files', [
            'id' => $projectFile->id,
        ]);

        Storage::disk('public')->assertMissing('projects/' . $project->id . '/photo.jpg');
    }

    public function testDownloadFile()
    {
        $project = Project::factory()->create();
        $projectFile = ProjectFile::factory()->create([
            'project_id' => $project->id,
            'file' => 'document.pdf',
            'mime_type' => 'application/pdf',
        ]);

        // Fake the file storage
        Storage::disk('public')->put('projects/' . $project->id . '/document.pdf', 'file content');

        $response = $this->projectFileService->downloadFile($project->id, $projectFile->id);

        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }
}
