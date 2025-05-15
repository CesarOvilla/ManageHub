<div class="max-w-screen-lg mx-auto p-4">
    <form wire:submit="save">
        <x-card class="space-y-6 p-6">

            {{-- Encabezado del formulario --}}
            <h1 class="text-center text-xl font-bold text-slate-800 dark:text-white">
                {{ $project ? __('Editar Proyecto') : __('Agregar Proyecto') }}
            </h1>

            {{-- Sección 1: Información básica --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200">Información General</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ts-input label="Nombre del Proyecto" wire:model="form.name" />
                    <x-ts-select.styled
                        label="Estado"
                        :options="$status"
                        select="label:label|value:value"
                        wire:model="form.status"
                    />
                </div>
                <x-ts-textarea label="Stakeholders" wire:model="form.stakeholders" />
            </div>

            {{-- Sección 2: Datos del Cliente --}}
            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200">Datos del Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ts-input label="Email Cliente" wire:model="form.client_email" />
                    <x-ts-input label="Contacto Cliente" wire:model="form.client_contact" />
                    <x-ts-input label="Convención" wire:model="form.convention" />
                </div>
            </div>

            {{-- Sección 3: Información técnica --}}
            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200">Repositorios y Servidor</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ts-input label="Repo Webapp" wire:model="form.repo_webapp" />
                    <x-ts-input label="Repo Mobile" wire:model="form.repo_mobile" />
                    <x-ts-input label="IP Servidor" wire:model="form.server_ip" />
                    <x-ts-input label="Credenciales SSH" wire:model="form.ssh_credentials" />
                    <x-ts-input label="Dominio" wire:model="form.domain" />
                    <x-ts-select.native label="Tipo" wire:model="form.type">
                        <option value="Client">Cliente</option>
                        <option value="Internal">Interno</option>
                    </x-ts-select.native>
                </div>
            </div>

            {{-- Sección 4: Asignación de Roles --}}
            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 space-y-4">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200">Asignación de Usuarios</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ts-select.styled
                        label="Project Manager"
                        :options="$project_managers"
                        select="label:label|value:value"
                        wire:model="form.project_manager"
                        searchable
                    />
                    <x-ts-select.styled
                        label="Program Manager"
                        :options="$program_managers"
                        select="label:label|value:value"
                        wire:model="form.program_manager"
                        searchable
                    />
                    <x-ts-select.styled
                        label="Cliente"
                        :options="$clients"
                        select="label:label|value:value"
                        wire:model="form.client"
                    />
                    <x-ts-select.styled
                        label="Software Developer"
                        :options="$developers"
                        select="label:label|value:value"
                        wire:model="form.developers"
                        multiple
                        searchable
                    />
                </div>
            </div>

            {{-- Botón de guardar --}}
            <div class="pt-6 text-right">
                <x-ts-button type="submit" text="Guardar Proyecto" />
            </div>

        </x-card>
    </form>
</div>
