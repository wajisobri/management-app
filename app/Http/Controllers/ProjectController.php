<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectDataTable;
use App\Http\Requests\CreateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(ProjectDataTable $dataTable)
    {
        $title = 'Delete Project!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $projects = $this->projectService->getProjects();

        return $dataTable->render('project.index', [
            'projects' => $projects,
        ]);
    }

    public function list(Request $request)
    {
        $title = 'Delete Project!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $search = $request->input('search', '');
        $length = $request->input('length', 6);
        $page = $request->input('page', 1);

        $projects = $this->projectService->getProjectsByParameter($search, $length, $page);

        return view('project.list', [
            'projects' => $projects
        ]);
    }

    public function store(CreateProjectRequest $request)
    {
        try {
            $request->validated();

            $this->projectService->createProject([
                'project_name' => $request->project_name,
                'project_description' => $request->project_description,
                'deadline' => $request->deadline,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'message' => 'Project created successfully',
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to create project',
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $project = $this->projectService->getProjectById($id);

            return response()->json([
                'message' => 'Project found',
                'data' => $project,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Project not found',
            ], 404);
        }
    }

    public function update(CreateProjectRequest $request, $id)
    {
        try {
            $request->validated();

            $this->projectService->updateProject($id, [
                'project_name' => $request->project_name,
                'project_description' => $request->project_description,
                'deadline' => $request->deadline,
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'message' => 'Project updated successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to update project',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->projectService->deleteProject($id);

            return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('projects.index')->with('error', 'Failed to delete project');
        }
    }
}
