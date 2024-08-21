<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectFileService.
 */
class ProjectFileService
{
    public function getProjectFileStatistics($projectId)
    {
        $project = Project::with('projectFiles')->findOrFail($projectId);

        $totalDocuments = 0;
        $totalImages = 0;
        $totalVideos = 0;
        $totalAudios = 0;

        foreach ($project->projectFiles as $file) {
            $mimeType = $file->mime_type;

            if (in_array($mimeType, ['application/pdf', 'text/plain', 'application/zip'])) {
                $totalDocuments++;
            } elseif (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml', 'image/webp'])) {
                $totalImages++;
            } elseif (in_array($mimeType, ['video/mp4', 'video/webm', 'video/mpeg', 'video/avi'])) {
                $totalVideos++;
            } elseif (in_array($mimeType, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/mpeg3', 'audio/x-mpeg-3'])) {
                $totalAudios++;
            }
        }

        $totalFiles = $totalDocuments + $totalImages + $totalVideos + $totalAudios;
        $pctDocuments = $totalFiles > 0 ? ($totalDocuments / $totalFiles) * 100 : 0;
        $pctImages = $totalFiles > 0 ? ($totalImages / $totalFiles) * 100 : 0;
        $pctVideos = $totalFiles > 0 ? ($totalVideos / $totalFiles) * 100 : 0;
        $pctAudios = $totalFiles > 0 ? ($totalAudios / $totalFiles) * 100 : 0;

        return [
            'project' => $project,
            'totalDocuments' => $totalDocuments,
            'totalImages' => $totalImages,
            'totalVideos' => $totalVideos,
            'totalAudios' => $totalAudios,
            'pctDocuments' => $pctDocuments,
            'pctImages' => $pctImages,
            'pctVideos' => $pctVideos,
            'pctAudios' => $pctAudios,
        ];
    }

    public function storeFiles($request)
    {
        $project = Project::findOrFail($request->id);
        $files = $request->file('file');

        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $fileMimeType = $file->getClientMimeType();
            $fileSize = $file->getSize();
            $fileExtension = $file->getClientOriginalExtension();

            Storage::disk('public')->put('projects/' . $project->id . '/' . $fileName, file_get_contents($file));

            $project->projectFiles()->create([
                'file' => $fileName,
                'mime_type' => $fileMimeType,
                'size' => $fileSize,
                'extension' => $fileExtension,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
    }

    public function deleteFile($projectId, $fileId)
    {
        $projectFile = ProjectFile::where('project_id', $projectId)
            ->where('id', $fileId)
            ->firstOrFail();

        if (Storage::disk('public')->exists('projects/' . $projectFile->project_id . '/' . $projectFile->file)) {
            Storage::disk('public')->delete('projects/' . $projectFile->project_id . '/' . $projectFile->file);
        }
        $projectFile->delete();
    }

    public function downloadFile($projectId, $fileId)
    {
        $projectFile = ProjectFile::where('project_id', $projectId)
            ->where('id', $fileId)
            ->firstOrFail();

        if (Storage::disk('public')->exists('projects/' . $projectFile->project_id . '/' . $projectFile->file)) {
            return response()->download(storage_path('app/public/projects/' . $projectFile->project_id . '/' . $projectFile->file));
        }

        throw new \Exception('File not found');
    }
}
