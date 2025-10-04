<?php

namespace App\Livewire\Dashboard\Projects\Cycle;

use App\Enums\DeliverableStatusEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Deliverable;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class DeliverableCard extends Component
{
    use Interactions;

    public Deliverable $deliverable;
    public $deliverable_search;



    public function changeStatus()
    {
        $deliverable = $this->deliverable;
        $currentStatus = DeliverableStatusEnum::tryFrom($deliverable->status);
        $nextStatus = DeliverableStatusEnum::getNextStatus($currentStatus);

        // validemos si tiene tareas del stage que no se han completado
        $tasks = Task::where('deliverable_id', $deliverable->id)->where('stage', $deliverable->status)->whereNot('status', TaskStatusEnum::TERMINADO->value)->get()->count();

        if ($tasks > 0) {
            $this->toast()->warning('Tienes tareas no terminadas')->send();
            return;
        }

        if ($nextStatus) {
            $deliverable->update(['status' => $nextStatus->value]);

            $ticket = $deliverable->ticket;

            if ($ticket) {
                $ticket->comments()->create(['content' => "Se cambia el status del entregable #{$deliverable->id} a {$nextStatus->value}", 'user_id' => Auth::user()->id]);
            }

            $this->dispatch('deliverableUpdated'); // Nuevo evento
        }
    }

    public function previousStatus()
    {
        $deliverable = $this->deliverable;
        $currentStatus = DeliverableStatusEnum::tryFrom($deliverable->status);
        $previousStatus = DeliverableStatusEnum::getPreviousStatus($currentStatus);

        if ($previousStatus) {
            $ticket = $deliverable->ticket;

            if ($ticket) {
                $ticket->comments()->create(['content' => "Se cambia el status del entregable #{$deliverable->id} a {$previousStatus->value}", 'user_id' => Auth::user()->id]);
            }
            $deliverable->update(['status' => $previousStatus->value]);
            $this->dispatch('deliverableUpdated'); // Nuevo evento
        }
    }
    
    public function render()
    {
        return view('livewire.dashboard.projects.cycle.deliverable-card');
    }
}
