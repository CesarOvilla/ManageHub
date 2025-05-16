<?php

namespace App\Livewire\Dashboard\Metrics;

use App\Enums\TaskStatusEnum;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TasksPerProjectChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        $team = Auth::user()->currentTeam;

        // Cargar proyectos del equipo actual con solo tareas sin event_id
        $projects = $team->projects()->with(['tasks' => function ($query) {
            $query->whereNull('event_id');
        }])->get();

        $categories = $projects->pluck('name')->toArray();
        $statuses = TaskStatusEnum::getValues();
        $series = [];

        foreach ($statuses as $status) {
            $data = [];

            foreach ($projects as $project) {
                // Contar tareas ya cargadas que coincidan con el status
                $count = $project->tasks->where('status', $status)->count();
                $data[] = $count;
            }

            $series[] = [
                'name' => is_object($status) ? $status->name : $status,
                'data' => $data,
            ];
        }

        $this->chartData = [
            'categories' => $categories,
            'series'     => $series,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.metrics.tasks-per-project-chart');
    }
}
