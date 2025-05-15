<?php

namespace App\Livewire\Dashboard\Projects;

use App\Enums\Roles;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectsList extends Component
{
    public $projects = [];
    public $search = ''; // Nueva propiedad para la búsqueda

    public function mount()
    {
        $this->filterProjects();
    }

    public function updatedSearch()
    {
        $this->filterProjects();
    }

    private function filterProjects()
    {
        $user = Auth::user();
        $query = Project::query()
        ->where('team_id', $user->currentTeam->id);
        // Aplicar permisos
        if (!$user->hasRole([Roles::ADMINISTRATOR->value, Roles::PROGRAM_MANAGER->value])) {
            $query->whereHas('users', fn($q) => $q->where('user_id', $user->id));
        }

        // Aplicar búsqueda
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $query->orderBy('name', 'asc');
        $this->projects = $query->get();
    }

    public function render()
    {
        return view('livewire.dashboard.projects.projects-list');
    }
}
