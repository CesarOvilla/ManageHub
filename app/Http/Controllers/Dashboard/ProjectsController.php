<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('dashboard.projects.index');
    }

    // public function create()
    // {
    //     return view('dashboard.users.create');
    // }

    // public function edit(User $user)
    // {
    //     return view('dashboard.users.edit', compact('user'));
    // }
}
