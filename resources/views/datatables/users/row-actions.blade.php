<div class="space-x-2">

    <div class='inline-block'>
        <a href="{{ route('dashboard.users.edit', $id) }}"
            class="flex justify-between items-center px-3 py-2 border rounded border-primary-400 text-primary-500 dark:text-primary-300">
            <span class="px-2">@svg('lucide-pencil', 'w-5 h-5')</span> Editar
        </a>
    </div>

    <div class='inline-block'>
        <button wire:click="$dispatch('openModal', { component: 'modals.cambio-tienda',arguments: { user: {{ $id }} }})"
            class="flex justify-between items-center px-3 py-2 border rounded border-red-400 text-red-500 dark:text-red-300">
            <span class="px-2">@svg('lucide-trash', 'w-5 h-5')</span> Eliminar
        </button>
    </div>

</div>
