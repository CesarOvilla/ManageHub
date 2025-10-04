<?php

namespace App\Livewire\Dashboard\Projects\Cycle;

use App\Enums\DeliverableStatusEnum;
use App\Enums\DeliverableTypeEnum;
use App\Enums\Roles;
use App\Enums\TaskStatusEnum;
use App\Enums\TicketStatusEnum;
use App\Models\Deliverable;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class StageComponent extends Component
{

    public $status;
    public $deliverable_search = null;
    public $deliverables = [];
    public $deliverables_collection;
    public $project;
    public $projectTickets;

    public $deliverables_type;
    public $status_deliverable_options;
    public $task_status;
    public $usersProject;


    public function mount()
    {
        $this->loadDeliverables();
        $this->loadProjectTickets();
        $this->loadTypesAndStatus();
        $this->loadDevelopersProjects();
    }
    // En tu componente Livewire StageComponent:

    #[On('deliverableUpdated')]
    public function loadDeliverables()
    {

        $deliverables = Deliverable::where('project_id', $this->project->id)
            ->where('status', $this->status)
            ->get();

        if ($this->deliverable_search) {
            $deliverable_id = $this->deliverable_search->id;

            // Separar el deliverable seleccionado del resto
            [$selected, $others] = $deliverables->partition(fn($d) => $d->id == $deliverable_id);

            // Reordenar la colección con el deliverable seleccionado primero
            $deliverables = $selected->merge($others);
        }

        $this->deliverables = $deliverables;

        $this->dispatch('loadStatusCount');
    }

    #[On('statusChanged')]
    public function changeStatus($status)
    {
        $this->status = $status;
        $this->loadDeliverables();
    }

    public function loadProjectTickets()
    {
        $this->projectTickets = Ticket::where('project_id', $this->project->id)->where('status', '<>', TicketStatusEnum::TERMINADO->value)->get();
    }

    public function loadTypesAndStatus()
    {
        $this->deliverables_type = DeliverableTypeEnum::asOptions();
        $this->status_deliverable_options = DeliverableStatusEnum::asOptions();
        $this->task_status = TaskStatusEnum::asOptions();
    }

    public function loadDevelopersProjects()
    {

        $users = User::wherehas('roles', fn($query) => $query->where('name', '<>', Roles::CLIENT->value))->get()->map(function ($user) {
            return [
                'label' => $user->name,
                'value' => $user->id,
                'image' => $user->profile_photo_url
            ];
        });

        $this->usersProject = $users;
    }

    public function addDeliverabeDraft()
    {
        $deliverable = Deliverable::create([
            'name' => 'NUEVO ENTREGABLE',
            'project_id' => $this->project->id,
            'status' => DeliverableStatusEnum::DRAFT->value,
            'ticket_id' => null,  // Explicitamente nulo
        ]);

        $this->loadDeliverables();
    }



    public function render()
    {
        return view('livewire.dashboard.projects.cycle.stage-component');
    }
}
