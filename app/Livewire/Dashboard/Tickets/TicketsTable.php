<?php

namespace App\Livewire\Dashboard\Tickets;

use App\Enums\Roles;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use TallStackUi\Traits\Interactions;

final class TicketsTable extends PowerGridComponent
{

    use Interactions;

    public string $tableName = 'tickets-table-tyrozd-table';

    public string $sortField = 'priority'; 

    public string $sortDirection = 'desc';

    public $deleteId;

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $user = Auth::user();
        $team = $user->currentTeam;
    
        $projects = ($user->hasRole(Roles::ADMINISTRATOR->value) || $user->hasRole(Roles::PROGRAM_MANAGER->value))
            ? $team->projects
            : $user->projects->where('team_id', $team->id);
    
        return Ticket::query()
            ->whereIn('project_id', $projects->pluck('id'))
            ->with(['project', 'user']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('user_id')
            ->add('project_id')
            ->add('title')
            ->add('description')
            ->add('status')
            ->add('order')
            ->add('priority')
            ->add('priority_action', fn($ticket) => view('datatables.tickets.priority-actions', ['id' => $ticket->id]))
            ->add('score')
            ->add('created_at') // el campo real
            ->add('created_at_formatted', function ($ticket) {
                return \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d');
            })
            ->add('user_name', fn($ticket) => optional($ticket->user)->name) // 👈 nombre del usuario
            ->add('project_name', fn($ticket) => optional($ticket->project)->name); // 👈 Aquí se define el nombre del proyecto
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),

            Column::make('Fecha', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Título', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Usuario', 'user_name')
                ->sortable(),

            Column::make('Proyecto', 'project_name')
                ->sortable()
                ->searchable(),

            Column::make('Estado', 'status')
                ->sortable(),

            Column::make('Prioridad', 'priority')
                ->sortable(),

            Column::make('Prioridad (+/-)', 'priority_action'),




            Column::action('Acciones')
        ];
    }

    public function actionsFromView($row): View
    {
        return view('datatables.tickets.row-actions', ['id' => $row->id]);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;

        $this->dialog()
            ->question(__('Eliminar'), __('¿Desea eliminar el ticket?'))
            ->confirm(__('Sí'), 'deleteConfirmed')
            ->cancel(__('No'), 'deleteCancelled')
            ->send();
    }

    public function deleteConfirmed()
    {
        Ticket::find($this->deleteId)->delete();
        $this->toast()->success(__('Ticket eliminado correctamente'))->send();
    }

    public function deleteCancelled()
    {
        $this->deleteId = null;
    }


    public function aumentarPrioridad($id)
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            $ticket->priority = $ticket->priority + 1; // Asumiendo que el máximo es 5
            $ticket->save();
        }
    }

    public function disminuirPrioridad($id)
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            $ticket->priority = max($ticket->priority - 1, 1); // Asumiendo que el mínimo es 1
            $ticket->save();
        }
    }
}
