@use('App\Enums\TicketStatusEnum')

<div class="mx-auto p-4">
    <form wire:submit="save">
        <x-card class="space-y-6 p-6">

            {{-- Encabezado --}}
            <h1 class="text-center text-xl font-bold text-slate-800 dark:text-white">
                {{ $ticket ? __('Editar Ticket') : __('Agregar Ticket') }}
            </h1>

            {{-- Título --}}
            <x-ts-input label="Título" wire:model="form.title" />

            {{-- Descripción con editor Quill --}}
            <div class="space-y-2">
                <label for="description" class="font-semibold text-slate-700 dark:text-slate-200 block">
                    Descripción
                </label>

                <livewire:ui.quill-text-editor
                    wire:key="description"
                    id="description"
                    wire:model.live="form.description"
                />

                @error('form.description')
                    <span class="text-red-500 text-sm">* {{ $message }}</span>
                @enderror
            </div>

            {{-- Selectores --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ts-select.styled
                    label="Usuario"
                    wire:model.live="form.user_id"
                    :options="$users"
                    select="label:label|value:value"
                    disabled="{{ $project }}"
                />

                <x-ts-select.styled
                    label="Proyecto"
                    wire:model.live="form.project_id"
                    :options="$projects"
                    select="label:label|value:value"
                    disabled="{{ $project }}"
                />

                <x-ts-select.styled
                    label="Status"
                    :options="TicketStatusEnum::asOptions()"
                    select="label:label|value:value"
                    wire:model.live="form.status"
                />
            </div>

            {{-- Botón guardar --}}
            <div class="pt-4 text-right">
                <x-ts-button type="submit" text="Guardar" />
            </div>
        </x-card>
    </form>

    {{-- Estilos para el editor Quill --}}
    <script wire:ignore>
        window.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                const editor = document.querySelector('.ql-editor');
                const toolbar = document.querySelector('.ql-toolbar');

                if (editor) {
                    editor.style.display = 'block';
                }

                if (toolbar) {
                    toolbar.style.position = 'sticky';
                    toolbar.style.top = '0';
                    // toolbar.style.backgroundColor = 'white';
                    toolbar.style.zIndex = '39';
                }
            }, 400);
        });
    </script>
</div>
