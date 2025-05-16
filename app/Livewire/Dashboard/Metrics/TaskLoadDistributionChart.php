<?php

namespace App\Livewire\Dashboard\Metrics;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskLoadDistributionChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        $team = Auth::user()->currentTeam;

        // Obtener todos los usuarios del equipo (incluyendo al owner)
        $teamUserIds = $team->allUsers()->pluck('id');

        // Obtener IDs únicos de usuarios que tienen tareas (sin event_id) en este equipo
        $userIds = Task::whereIn('user_id', $teamUserIds)
            ->whereNull('event_id')
            ->pluck('user_id')
            ->unique()
            ->filter()
            ->values();

        // Cargar los usuarios para el gráfico
        $users = User::whereIn('id', $userIds)->get(['id', 'name']);
        $categories = $users->pluck('name')->toArray();

        $tasksStatus = TaskStatusEnum::getValues();
        $series = [];

        foreach ($tasksStatus as $status) {
            $data = [];

            foreach ($users as $user) {
                $count = Task::where('user_id', $user->id)
                    ->where('status', $status)
                    ->whereNull('event_id')
                    ->count();

                $data[] = $count;
            }

            $series[] = [
                'name' => is_object($status) ? $status->name : $status,
                'data' => $data,
            ];
        }

        $this->chartData = [
            'categories' => $categories,
            'series' => $series,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.metrics.task-load-distribution-chart');
    }
}
