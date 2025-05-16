<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Event;

class EventsController extends Controller
{
    public function index()
    {
        return view('dashboard.events.index');
    }

    public function create()
    {
        return view('dashboard.events.create');
    }

    public function edit(Event $event)
    {
        return view('dashboard.events.edit', compact('event'));
    }


}
