<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('dashboard.projects.index');
    }

    public function create()
    {
        return view('dashboard.projects.create');
    }

    public function edit(Project $project)
    {
        return view('dashboard.projects.edit', compact('project'));
    }

    public function show(Project $project, ?Deliverable $deliverable = null)
    {
        return view('dashboard.projects.show', compact('project', 'deliverable'));
    }
}
