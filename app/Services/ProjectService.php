<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Log;

/**
 * Class ProjectService.
 */
class ProjectService
{
    public function getProjects()
    {
        return Project::with('userCreated')
            ->select('id', 'project_name', 'project_description', 'deadline', 'created_by', 'created_at')
            ->orderBy('created_at', 'desc');
    }

    public function getProjectsByParameter($search = '', $length = 6, $page = 1)
    {
        $query = Project::with('userCreated')
            ->select('id', 'project_name', 'project_description', 'deadline', 'created_by', 'created_at');

        if ($search) {
            $query->where('project_name', 'like', "%$search%")
                ->orWhere('project_description', 'like', "%$search%")
                ->orWhere('deadline', 'like', "%$search%")
                ->orWhereHas('userCreated', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($length, ['*'], 'page', $page);
    }

    public function getProjectById($id)
    {
        try {
            return Project::findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function createProject(array $data)
    {
        try {
            return Project::create([
                'project_name' => $data['project_name'],
                'project_description' => $data['project_description'],
                'deadline' => $data['deadline'],
                'created_by' => $data['created_by'] ?? null,
                'updated_by' => $data['updated_by'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updateProject($id, array $data)
    {
        try {
            $project = Project::findOrFail($id);
            $project->update([
                'project_name' => $data['project_name'],
                'project_description' => $data['project_description'],
                'deadline' => $data['deadline'] ?? null,
                'updated_by' => $data['updated_by'] ?? null,
            ]);
            return $project;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function deleteProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
