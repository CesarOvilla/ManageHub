<?php

namespace App\Livewire\Dashboard\Tickets;

use App\Enums\TicketStatusEnum;
use Livewire\Component;
use App\Livewire\Forms\TicketForm;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FormComponent extends Component
{
    public ?Project $project = null;
    public ?Ticket $ticket = null;
    public TicketForm $form;

    public array $users = [];
    public array $projects = [];

    public function mount(): void
    {
        $this->loadUsers();

        if ($this->ticket) {
            $this->form->fill($this->ticket->toArray());
            $this->loadProjects($this->form->user_id);
        }

        if ($this->project) {
            $this->form->user_id = Auth::id();
            $this->form->project_id = $this->project->id;
            $this->loadProjects(Auth::id());
        }

        $this->form->user_id = Auth::id();
        $this->loadProjects($this->form->user_id);
    }

    protected function getTeam()
    {
        return Auth::user()->currentTeam;
    }

    public function loadUsers(): void
    {
        $team = $this->getTeam();

        $this->users = $team->allUsers()
            ->map(fn($user) => [
                'label' => $user->name,
                'value' => $user->id,
            ])
            ->toArray();
    }

    public function updatedFormUserId($value): void
    {
        $this->form->project_id = null;
        $this->loadProjects($value);
    }

    public function updatedFormStatus($value): void
    {
        if (!$value) {
            $this->form->status = TicketStatusEnum::PENDIENTE->value;
        }
    }

    public function loadProjects($userId): void
    {
        $teamId = $this->getTeam()->id;

        $projects = Project::where('team_id', $teamId)
            ->when($userId, function ($query) use ($userId) {
                $query->whereHas('users', fn($q) => $q->where('user_id', $userId));
            })
            ->get();

        $this->projects = $projects->map(fn($project) => [
            'label' => $project->name,
            'value' => $project->id,
        ])->toArray();
    }

    public function save(): void
    {
        $this->validate();

        $ticket = $this->form->store();

        if ($this->project) {
            to_route('dashboard.projects.tickets', $this->project->id);
        } else {
            to_route('dashboard.tickets.show', $ticket->id);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.tickets.form-component');
    }
}
