<div class="space-x-2">

        <x-ui.tooltip :text="__('Editar')">
            <a href="{{ route('dashboard.events.edit', $id) }}">
                @svg('heroicon-o-pencil-square', 'w-5 h-5 text-primary-800 dark:text-primary-300')
            </a>
        </x-ui.tooltip>

        <x-ui.tooltip :text="__('Eliminar')">
            <button type="button" wire:click="confirmDelete({{ $id }})">
                @svg('heroicon-o-trash', 'w-5 h-5 text-red-800 dark:text-red-400')
            </button>
        </x-ui.tooltip>
</div>
