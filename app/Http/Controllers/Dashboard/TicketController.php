<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return view('dashboard.tickets.index');
    }

    public function create()
    {
        return view('dashboard.tickets.create');
    }

    public function edit(Ticket $ticket)
    {
        return view('dashboard.tickets.edit', compact('ticket'));
    }

    public function show(Ticket $ticket)
    {
        return view('dashboard.tickets.show', compact('ticket'));
    }
}
