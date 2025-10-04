<?php

namespace App\Livewire\Dashboard\Projects;

use Livewire\Component;

class DetailProject extends Component
{
    public $project;
    public function render()
    {
        return view('livewire.dashboard.projects.detail-project');
    }
}
