<form wire:submit="save">
    <x-card >
        <h1 class="text-center text-lg font-semibold text-slate-800 dark:text-slate-100">
            {{ $user ? 'Editar usuario' : 'Agregar usuario' }}
        </h1>

        <div>
            <x-ts-input
                id="name"
                type="text"
                wire:model="form.name"
                label="{{ __('Name') }}"
                class="text-slate-800 dark:text-slate-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700"
            />
        </div>

        <div>
            <x-ts-input
                id="email"
                type="text"
                wire:model="form.email"
                label="{{ __('Email') }}"
                class="text-slate-800 dark:text-slate-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700"

            />
        </div>

        <div>
            <x-ts-password
                id="password"
                wire:model="form.password"
                label="{{ __('Password') }}"
                class="text-slate-800 dark:text-slate-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700"

            />
        </div>

        <div>
            <x-ts-select.styled
                label="{{ __('Roles') }}"
                :options="$roles"
                select="label:label|value:value"
                wire:model="form.roles"
                multiple
                class="text-slate-800 dark:text-slate-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700"

            />
        </div>

        <div class="text-right pt-2">
            <x-ts-button class="bg-primary-600 hover:bg-primary-700 text-white dark:bg-primary-500 dark:hover:bg-primary-600">
                Guardar
            </x-ts-button>
        </div>
    </x-card>
</form>
