<?php

namespace App\Livewire\Dashboard\Events;

use App\Enums\EventScheduleTypeEnum;
use App\Enums\EventTypeEnum;
use Livewire\Component;
use App\Models\Event;
use App\Livewire\Forms\EventForm;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FormComponent extends Component
{
    public ?Event $event = null;

    public EventForm $form;

    public $eventTypes = [];
    public $scheduleTypes = [];
    public $weekDays = [
        ['label' => 'Lunes', 'value' => 'monday'],
        ['label' => 'Martes', 'value' => 'tuesday'],
        ['label' => 'Miércoles', 'value' => 'wednesday'],
        ['label' => 'Jueves', 'value' => 'thursday'],
        ['label' => 'Viernes', 'value' => 'friday'],
        ['label' => 'Sábado', 'value' => 'saturday'],
        ['label' => 'Domingo', 'value' => 'sunday'],
    ];

    public $projects = [];
    public $users = [];

    public function mount(): void
    {
        $this->eventTypes = EventTypeEnum::asOptions();
        $this->scheduleTypes = EventScheduleTypeEnum::asOptions();
        $this->loadProjects();
        $this->loadUsers();
        if ($this->event) {
            $this->form->fill($this->event->toArray());
            $this->form->users_id = $this->event->users->pluck('id')->toArray();
        }
    }
    public function loadProjects(): void
    {
        $team = Auth::user()->currentTeam;

        $this->projects = $team->projects()
            ->get()
            ->map(fn($project) => [
                'label' => $project->name,
                'value' => $project->id,
            ])
            ->toArray();
    }


    public function updatedFormScheduleType($value)
    {
        if ($value == EventScheduleTypeEnum::DAILY->value) {
            $this->form->days_of_week = null; // No se usa
        } elseif ($value == EventScheduleTypeEnum::DAYS_OF_WEEK->value) {
            $this->form->days_of_week = []; // Debe ser un array vacío o una lista de días
        } elseif (in_array($value, [EventScheduleTypeEnum::WEEKLY->value, EventScheduleTypeEnum::TWO_WEEKS->value])) {
            $this->form->days_of_week  = null; // Debe ser un solo valor
        } elseif ($value == EventScheduleTypeEnum::MONTHLY->value) {
            $this->form->days_of_week = null; // Debe ser un número
        }
    }


    public function loadUsers(): void
    {
        $team = Auth::user()->currentTeam;

        $this->users = $team->allUsers()
            ->map(fn($user) => [
                'label' => $user->name,
                'value' => $user->id,
            ])
            ->toArray();
    }


    public function updatedFormProjectId($value): void
    {
        $project = Project::where('id', $value)
            ->where('team_id', Auth::user()->currentTeam->id)
            ->with('users')
            ->first();
    
        $this->form->users_id = $project?->users->pluck('id')->toArray() ?? [];
    }
    

    public function save()
    {
        $this->validate();

        $this->form->store();

        to_route('dashboard.events.index');
    }

    public function render()
    {
        return view('livewire.dashboard.events.form-component');
    }
}
