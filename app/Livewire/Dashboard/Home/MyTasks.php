<?php

namespace App\Livewire\Dashboard\Home;

use App\Enums\Roles;
use App\Enums\TaskStatusEnum;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskDailyLog;
use App\Traits\HandlesUserSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class MyTasks extends Component
{
    use Interactions, HandlesUserSettings;

    public $activeTab = null;
    public $project_select = null;
    public $tasks = [];
    public $projects;
    public $projects_options = [];
    public $project_id = null;
    public $stopId = null;

    public function mount()
    {
        $this->loadProjects();
        $this->loadTasks();
        $this->projects_options = $this->projects->map(fn($project) => [
            'value' => $project->id,
            'label' => $project->name,
        ])->toArray();
    }

    private function loadProjects()
    {
        $user = Auth::user();
        $userId = $user->id;

        $tasks = Task::where('user_id', $userId)->pluck('project_id')->unique();

        $this->projects = $user->hasAnyRole([Roles::ADMINISTRATOR->value, Roles::PROGRAM_MANAGER->value])
            ? Project::all()
            : Project::whereIn('id', $tasks)->get();
    }

    private function loadTasks($projectId = null)
    {
        $userId = Auth::id();

        $query = Task::where('user_id', $userId)
            ->where('status', '<>', TaskStatusEnum::TERMINADO->value)
            ->where(function ($q) {
                // Incluir tareas sin deliverable
                $q->whereNull('deliverable_id')
                    // Incluir tareas donde el deliverable.status sea igual al stage de la tarea
                    ->orWhereHas('deliverable', function ($q) {
                        $q->whereColumn('status', 'tasks.stage');
                    });
            })
            ->orderBy('is_urgent', 'desc')
            ->orderBy('priority', 'desc');

        if ($projectId) {
            $query->where('project_id', $projectId);
        } else {
            $query->whereIn('project_id', $this->projects->pluck('id'));
        }

        $this->tasks = $query->get();
    }


    public function updatedProjectId($id)
    {
        $this->activeTab = $id;
        $this->project_select = $id ? Project::find($id) : null;
        $this->loadTasks($id);
    }

    public function startTask(Task $task)
    {
        if (Task::where('user_id', Auth::id())->where('status', TaskStatusEnum::EN_PROGRESO->value)->exists()) {
            $this->toast()->warning('Ya tienes una tarea en ejecución')->send();
            return;
        }

        $task->update([
            'status' => TaskStatusEnum::EN_PROGRESO->value,
            'started_at' => Carbon::now('UTC'),
        ]);

        $this->loadTasks();
    }

    public function pauseTask(Task $task)
    {
        if ($task->status !== TaskStatusEnum::EN_PROGRESO->value) {
            $this->toast()->warning('La tarea no se puede pausar')->send();
            return;
        }

        $this->logTimeAndPause($task);
        $this->loadTasks();
    }

    private function logTimeAndPause(Task $task)
    {
        $userTimezone = json_decode($this->getSettingByUser($task->user_id, 'timezone')) ?? 'America/Mexico_City';
        $nowLocal = Carbon::now()->setTimezone($userTimezone);
        $startLocal = $task->started_at->setTimezone($userTimezone);
        $diff = $startLocal->diffInSeconds($nowLocal);

        $this->logDailyTime($task, $diff, $userTimezone);

        $task->update([
            'elapsed_time' => $task->elapsed_time + $diff,
            'status' => TaskStatusEnum::PAUSADA->value,
            'started_at' => null,
        ]);
    }

    public function confirmStop($id)
    {
        $this->stopId = $id;
        $this->dialog()
            ->question('Finalizar', '¿Desea finalizar la tarea?')
            ->confirm(__('Yes'), 'StopConfirmed')
            ->cancel(__('No'), 'stopCancelled')
            ->send();
    }

    public function StopConfirmed()
    {
        $task = Task::find($this->stopId);
        $this->stopTask($task);
        $this->toast()->success('Tarea finalizada')->send();
    }

    public function stopCancelled()
    {
        $this->stopId = null;
    }

    public function stopTask(Task $task)
    {
        if ($task->status !== TaskStatusEnum::EN_PROGRESO->value) {
            $this->toast()->warning('La tarea no se puede detener')->send();
            return;
        }

        $this->logTimeAndComplete($task);
        $this->loadTasks();
    }

    private function logTimeAndComplete(Task $task)
    {
        $userTimezone = json_decode($this->getSettingByUser($task->user_id, 'timezone')) ?? 'America/Mexico_City';
        $nowLocal = Carbon::now('UTC')->setTimezone($userTimezone);
        $startLocal = $task->started_at->setTimezone($userTimezone);
        $diff = $startLocal->diffInSeconds($nowLocal);

        $this->logDailyTime($task, $diff, $userTimezone);

        $task->update([
            'elapsed_time' => $task->elapsed_time + $diff,
            'status' => TaskStatusEnum::TERMINADO->value,
            'started_at' => null,
        ]);
    }

    private function logDailyTime(Task $task, int $elapsedSeconds, string $timezone)
    {
        if (!$task->started_at) {
            Log::warning("El campo 'started_at' es null para la tarea ID: {$task->id}. No se puede registrar el tiempo.");
            return;
        }

        $startLocal = $task->started_at->setTimezone($timezone);
        $nowLocal = Carbon::now($timezone);

        while ($elapsedSeconds > 0) {
            $currentDate = $startLocal->format('Y-m-d');
            $endOfDay = $startLocal->copy()->endOfDay();
            $remainingSecondsToday = $startLocal->diffInSeconds($endOfDay);

            $secondsToLog = min($elapsedSeconds, $remainingSecondsToday + 1);

            $log = TaskDailyLog::firstOrCreate(
                ['task_id' => $task->id, 'date' => $currentDate],
                ['daily_elapsed_time' => 0]
            );

            $log->daily_elapsed_time += $secondsToLog;
            $log->save();

            Log::info("Tiempo registrado: {$secondsToLog} segundos para la fecha {$currentDate}");

            $elapsedSeconds -= $secondsToLog;
            $startLocal = $startLocal->copy()->addSeconds($secondsToLog)->startOfDay();
        }
    }

    public function aumentarPrioridad($id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->priority = $task->priority + 1; // Asumiendo que el máximo es 5
            $task->save();
        }
        $this->loadTasks();
    }

    public function disminuirPrioridad($id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->priority = max($task->priority - 1, 1); // Asumiendo que el mínimo es 1
            $task->save();
        }
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.dashboard.home.my-tasks');
    }
}
