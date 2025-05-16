<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Event;

class MetricsController extends Controller
{
    public function index()
    {
        return view('dashboard.metrics.index');
    }

}
