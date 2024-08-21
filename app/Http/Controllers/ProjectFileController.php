<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectFileDataTable;
use App\Services\ProjectFileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    protected $projectFileService;

    public function __construct(ProjectFileService $projectFileService)
    {
        $this->projectFileService = $projectFileService;
    }

    public function index(Request $request, ProjectFileDataTable $dataTable)
    {
        try {
            $data = $this->projectFileService->getProjectFileStatistics($request->id);
            $title = 'Delete Project File!';
            $text = "Are you sure you want to delete?";
            confirmDelete($title, $text);

            return $dataTable->with('project_id', $request->id)
                ->render('project.file.index', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Project not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch project files');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file.*' => 'required|file|max:51200',
        ]);

        try {
            $this->projectFileService->storeFiles($request);
            return redirect()->back()->with('success', 'Files uploaded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload files: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->projectFileService->deleteFile($request->id, $request->fileId);
            return redirect()->back()->with('success', 'File deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'File not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete file');
        }
    }

    public function download(Request $request)
    {
        try {
            return $this->projectFileService->downloadFile($request->id, $request->fileId);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'File not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download file');
        }
    }
}
