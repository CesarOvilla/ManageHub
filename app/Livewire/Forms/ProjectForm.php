<?php

namespace App\Livewire\Forms;

use App\Enums\ProjectStatusEnum;
use App\Enums\Roles;
use Livewire\Form;
use App\Models\Project;

class ProjectForm extends Form
{
    public $id;
    public $team_id;
    public $status = ProjectStatusEnum::LEVANTAMIENTO_DE_REQUERIMIENTOS->value;
    public $name;
    public $stakeholders;
    public $client_email;
    public $client_contact;
    public $convention;
    public $repo_webapp;
    public $repo_mobile;
    public $server_ip;
    public $ssh_credentials;
    public $domain;
    public $type = 'Client';

    //relaciones de usarios
    public $project_manager;
    public $program_manager;
    public $client;
    public $developers = []; // Este es un array porque es múltiple

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'stakeholders' => ['required', 'string'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_contact' => ['nullable', 'string', 'max:255'],
            'convention' => ['required', 'string', 'max:255', 'unique:projects,convention,' . $this->id],
            'repo_webapp' => ['nullable', 'url', 'max:255'],
            'repo_mobile' => ['nullable', 'url', 'max:255'],
            'server_ip' => ['nullable', 'string', 'max:255'],
            'ssh_credentials' => ['nullable', 'string'],
            'domain' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ];
    }

    public function store(): Project
    {
        // Guardar proyecto
        $project = Project::find($this->id);

        if ($project) {
            $project->update($this->except(['project_manager', 'program_manager', 'client', 'developers', 'team_id']));
        } else {
            $project = Project::create([
                'team_id' => $this->team_id,
                ...$this->except(['project_manager', 'program_manager', 'client', 'developers', 'team_id']),
            ]);
        }

        // Limpiar relaciones anteriores
        $project->users()->detach();

        // Asignar usuarios con sus roles
        if ($this->project_manager) {
            $project->users()->attach($this->project_manager, ['role' => Roles::PROJECT_MANAGER]);
        }

        if ($this->program_manager) {
            $project->users()->attach($this->program_manager, ['role' => Roles::PROGRAM_MANAGER]);
        }

        if ($this->client) {
            $project->users()->attach($this->client, ['role' => Roles::CLIENT]);
        }

        if (!empty($this->developers)) {
            foreach ($this->developers as $developerId) {
                $project->users()->attach($developerId, ['role' => Roles::SOFTWARE_DEVELOPER]);
            }
        }

        return $project;
    }
}
