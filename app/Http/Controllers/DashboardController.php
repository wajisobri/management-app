<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProject = Project::count();
        $totalRecentProject = Project::where('created_at', '>=', now()->subDays(30))->count();
        $totalActiveProject = Project::where('deadline', '>=', now())->count();
        $totalCompletedProject = $totalProject - $totalActiveProject;

        return view('dashboard', [
            'totalProject' => $totalProject,
            'totalRecentProject' => $totalRecentProject,
            'totalActiveProject' => $totalActiveProject,
            'totalCompletedProject' => $totalCompletedProject,
        ]);
    }
}
