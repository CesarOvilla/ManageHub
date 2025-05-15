<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public $id;

    public $name;

    public $email;

    public $password;

    public $roles = [];

    public $permissions = [];

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string'],
        ];

        if (! $this->id) {
            $rules['password'][] = ['required', 'string', 'min:8'];
        }


        return $rules;
    }

    public function store(): User
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        $user = User::updateOrCreate(
            ['id' => $this->id],
            $data
        );

        // 🔐 Roles y permisos
        $user->syncRoles($this->roles);
        $user->syncPermissions($this->permissions);

        // 🧩 Asociar al equipo si es nuevo
        if (! $this->id) {
            $team = Auth::user()->currentTeam;

            if ($team) {
                $user->current_team_id = $team->id;
                $user->save();

                if (! $team->users->contains($user->id)) {
                    $team->users()->attach($user, ['role' => null]);
                }
            }
        }
        return $user;
    }
}
