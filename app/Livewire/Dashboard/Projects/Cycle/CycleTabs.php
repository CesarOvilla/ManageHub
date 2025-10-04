<?php

namespace App\Livewire\Dashboard\Projects\Cycle;

use App\Enums\DeliverableStatusEnum;
use App\Enums\Roles;
use App\Models\Deliverable;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\Attributes\On;
use Livewire\Component;

class CycleTabs extends Component
{
    public $currentTab = 'Rundown'; // Mantiene el tab seleccionado
    public $project;

    public $status_deliverable_count = [];
    public $statuses = [];

    public $deliverable_search;

    public function mount()
    {
        $user = FacadesAuth::user();
        $this->statuses = DeliverableStatusEnum::getValues();
        $this->currentTab = DeliverableStatusEnum::DRAFT->value;

        if (!$user->hasAnyRole([Roles::ADMINISTRATOR->value, Roles::PROGRAM_MANAGER->value, Roles::PROJECT_MANAGER->value, Roles::PMO->value])) {
            array_shift($this->statuses);
            $this->currentTab = DeliverableStatusEnum::RUNDOWN->value;
        }
        array_pop($this->statuses);
        if ($this->deliverable_search) {
            $this->currentTab = $this->deliverable_search->status;
        }


        $this->loadDeliverablesByStatusCount();
    }

    public function selectTab($tab)
    {
        $this->currentTab = $tab; // Cambiar el tab

        //distapach
        $this->dispatch('statusChanged', $tab);
    }

    #[On('loadStatusCount')]
    public function loadDeliverablesByStatusCount()
    {
        foreach ($this->statuses as $status) {
            $this->status_deliverable_count[$status] = Deliverable::where('project_id', $this->project->id)->where('status', $status)->count();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.projects.cycle.cycle-tabs');
    }
}
