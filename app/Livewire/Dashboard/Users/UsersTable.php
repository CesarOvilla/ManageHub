<?php

namespace App\Livewire\Dashboard\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class UsersTable extends DataTableComponent
{
    use Interactions;
    protected $model = User::class;

    public $deleteId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }
    
    public function builder(): Builder
    {
        $user = Auth::user();
        $team = $user->currentTeam;
    
        if (!$team) {
            return User::query()->whereRaw('0 = 1');
        }
    
        $excludedIds = [
            $team->owner->id,  // Excluir al owner
            $user->id,         // Excluir al usuario autenticado
        ];
    
        $userIds = $team->allUsers()->pluck('id')->diff($excludedIds);
    
        return User::query()->whereIn('id', $userIds);
    }
    

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Acciones", 'id')
                ->format(function ($id) {
                    return view('datatables.users.row-actions', compact('id'));
                }),
        ];
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;

        $this->dialog()
            ->question(__('panel.general.eliminar'), __('panel.usuarios.desea_eliminar'))
            ->confirm(__('Yes'), 'deleteConfirmed')
            ->cancel(__('No'), 'deleteCancelled')
            ->send();
    }

    public function deleteConfirmed()
    {
        User::find($this->deleteId)->delete();
        $this->toast()->success(__('panel.usuarios.eliminado_correctamente'))->send();
    }

    public function deleteCancelled()
    {
        $this->deleteId = null;
    }
}
