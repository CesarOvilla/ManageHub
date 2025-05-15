<?php

namespace App\Livewire\Dashboard\Projects;

use App\Enums\ProjectStatusEnum;
use App\Enums\Roles;
use Livewire\Component;
use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FormComponent extends Component
{
    public ?Project $project = null;
    public ProjectForm $form;

    public array $status = [];

    public $developers = [];
    public $project_managers = [];
    public $program_managers = [];
    public $clients = [];



    public function mount(): void
    {
        if ($this->project) {
            $this->form->fill($this->project->toArray());

            // Cargar relaciones de usuarios
            $this->form->project_manager = optional($this->project->projectManager())->id;
            $this->form->program_manager = optional($this->project->programManager())->id;
            $this->form->client = optional($this->project->client())->id;
            $this->form->developers = $this->project->developers()->pluck('users.id')->toArray();
        }

        $this->status = ProjectStatusEnum::asOptions();
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $team = Auth::user()->currentTeam;
    
        $allUsers = $team->allUsers()->load('roles'); // eager load para evitar N+1
    
        $this->developers = $allUsers->filter(fn($user) =>
            $user->hasRole(Roles::SOFTWARE_DEVELOPER)
        )->map(fn($user) => [
            'label' => $user->name,
            'value' => $user->id,
            'image' => $user->profile_photo_url
        ])->values()->toArray();
    
        $this->project_managers = $allUsers->filter(fn($user) =>
            $user->hasRole(Roles::PROJECT_MANAGER)
        )->map(fn($user) => [
            'label' => $user->name,
            'value' => $user->id,
            'image' => $user->profile_photo_url
        ])->values()->toArray();
    
        $this->program_managers = $allUsers->filter(fn($user) =>
            $user->hasRole(Roles::PROGRAM_MANAGER)
        )->map(fn($user) => [
            'label' => $user->name,
            'value' => $user->id,
            'image' => $user->profile_photo_url
        ])->values()->toArray();
    
        $this->clients = $allUsers->filter(fn($user) =>
            $user->hasRole(Roles::CLIENT)
        )->map(fn($user) => [
            'label' => $user->name,
            'value' => $user->id,
            'image' => $user->profile_photo_url
        ])->values()->toArray();
    }



    public function save()
    {
        $this->form->team_id = Auth::user()->currentTeam->id;

        $this->validate();
        $project = $this->form->store();
        to_route('dashboard.projects.show', $project->id);
    }

    public function render()
    {
        return view('livewire.dashboard.projects.form-component');
    }
}
