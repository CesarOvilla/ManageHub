<?php

namespace App\Livewire\Dashboard\Metrics;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskTrackCompletionChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        $teamUserIds = Auth::user()->currentTeam->allUsers()->pluck('id');

        $tasksStatus = TaskStatusEnum::getValues();
        $labels = [];
        $series = [];

        foreach ($tasksStatus as $status) {
            $label = is_object($status) ? $status->name : $status;
            $labels[] = $label;

            $series[] = Task::whereIn('user_id', $teamUserIds)
                ->where('status', $status)
                ->whereNull('event_id')
                ->count();
        }

        $this->chartData = [
            'labels' => $labels,
            'series' => $series,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.metrics.task-track-completion-chart');
    }
}
