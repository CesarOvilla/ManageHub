@use('App\Enums\TicketStatusEnum')

<div>
    <form wire:submit="save">
        <x-card class="space-y-4">
            <h1 class="text-center text-lg font-semibold">
                {{ $ticket ? __('Editar Ticket') : __('Agregar Ticket') }}
            </h1>
            <x-ts-input label="{{ __('Titulo') }}" wire:model="form.title" />
            <div>
                <span class="font-semibold">Descripción:</span>
                <livewire:ui.quill-text-editor wire:key="description" id="description"
                    wire:model.live="form.description" />

                @error('form.description')
                    <span class="text-red-500 text-sm">* {{ $message }} </span>
                @enderror

            </div>

            <x-ts-select.styled label="{{ __('Usuario') }}" wire:model.live="form.user_id" :options="$users"
                select="label:label|value:value" disabled="{{ $project }}" />

            <x-ts-select.styled label="{{ __('Proyecto') }}" wire:model.live="form.project_id" :options="$projects"
                select="label:label|value:value" disabled="{{ $project }}" />

            <x-ts-select.styled label="{{ __('Status') }}" :options="TicketStatusEnum::asOptions()" select="label:label|value:value"
                wire:model.live="form.status" />

            <div class="text-right">
                <x-ts-button type="submit" text="Guardar" />
            </div>
        </x-card>
    </form>
    <script wire:ignore>
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                $editor = document.querySelector('.ql-editor');
                $editor.style.display = 'block';
                // add sticky toolbar
                $toolbar = document.querySelector('.ql-toolbar');
                $toolbar.style.position = 'sticky';
                $toolbar.style.top = '0';
                $toolbar.style.backgroundColor = 'white';
                $toolbar.style.zIndex = '39';

            }, 400);
        });
    </script>
</div>
