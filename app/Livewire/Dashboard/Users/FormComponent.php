<?php

namespace App\Livewire\Dashboard\Users;

use App\Enums\Roles;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;

class FormComponent extends Component
{
    public ?User $user = null;

    public UserForm $form;

    public function mount(): void
    {
        if ($this->user) {
            $this->form->fill([
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'roles' => $this->user->roles->pluck('name')->toArray(),
                'permissions' => $this->user->permissions->pluck('name')->toArray() ?? [],
            ]);
        }
    }

    public function updatedFormRoles()
    {
        $permissionList = [];

        foreach ($this->form->roles as $role) {
            $modules = config("roles.roles_modules.$role", []);
            foreach ($modules as $module) {
                $permissionList = array_merge(
                    $permissionList,
                    config("roles.permissions.$module", [])
                );
            }
        }

        $this->form->permissions = array_unique($permissionList);
    }
    
    public function setPermissionsForModule($module)
    {
        $permissions = config('roles.permissions.'.$module, []);
        $missingPermissions = array_diff($permissions, $this->form->permissions);

        if (empty($missingPermissions)) {
            $this->form->permissions = array_diff($this->form->permissions, $permissions);

            return;
        }

        $this->form->permissions = array_merge($this->form->permissions, $missingPermissions);
    }

    public function save()
    {
        $this->validate();

        $this->form->store();

        to_route('dashboard.users.index');
    }

    public function render()
    {
        return view('livewire.dashboard.users.form-component', [
            'roles' => Roles::asOptions(),
            'permissions' => config('roles.permissions'),
        ]);
    }
}
