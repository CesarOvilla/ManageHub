<div class="space-x-2">

    <x-ui.tooltip text="Aumentar Prioridad">
        <button wire:click="aumentarPrioridad({{ $id }})" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 me-1 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            <x-heroicon-o-chevron-up class="w-5 h-5" />

        </button>
    </x-ui.tooltip>
    <x-ui.tooltip text="Disminuir Prioridad">
        <button wire:click="disminuirPrioridad({{ $id }})" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 me-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
            <x-heroicon-o-chevron-down class="w-5 h-5" />
        </button>
    </x-ui.tooltip>

</div>
