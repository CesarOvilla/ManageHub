<?php

namespace App\Livewire\Dashboard\Events;

use App\Models\Event;
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

final class EventsTable extends PowerGridComponent
{
    use Interactions;
    public string $tableName = 'events-table-gykywm-table';
    public $deleteId;

    public function setUp(): array
    {

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
        $team = Auth::user()->currentTeam;

        // IDs de proyectos del equipo actual
        $projectIds = $team->projects()->pluck('id');

        return Event::query()
            ->whereIn('project_id', $projectIds)
            ->with('project'); // opcional si luego quieres mostrar nombre de proyecto
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('type')
            ->add('duration_minutes')
            ->add('project_name', fn($event) => optional($event->project)->name)
            ->add('start_time');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make(__('Nombre'), 'name')->sortable()->searchable(),
            Column::make(__('Proyecto'), 'project_name')->sortable()->searchable(),
            Column::make(__('Tipo'), 'type')->sortable()->searchable(),
            Column::make(__('Duración (minutos)'), 'duration_minutes')->sortable(),
            Column::make(__('Hora de inicio'), 'start_time')->sortable(),
            Column::action('Acciones'),
        ];
    }

    public function filters(): array
    {
        return [];
    }


    public function actionsFromView($row): View
    {
        return view('datatables.events.row-actions', ['id' => $row->id]);
    }

    public function confirmDelete($rowId): void
    {
        $this->deleteId = $rowId;

        $this->dialog()
            ->question(__('Eliminar evento'), '¿Desea eliminar el evento?')
            ->confirm(__('Sí'), 'deleteConfirmed')
            ->cancel(__('No'), 'deleteCancelled')
            ->send();
    }

    public function deleteConfirmed(): void
    {
        Event::find($this->deleteId)?->delete();
        $this->toast()->success('Evento eliminado correctamente')->send();
        $this->deleteId = null;
    }

    public function deleteCancelled(): void
    {
        $this->deleteId = null;
    }
}
