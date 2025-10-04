@use('App\Enums\DeliverableStatusEnum')

<div
    class="flex flex-wrap sm:flex-nowrap items-center gap-4 p-2"
    x-data="{ localSaving: false, lastSave: '' }"
    x-init="
        $wire.on('saving-started', (event) => {
            if (event.id == {{ $deliverable->id }}) {
                localSaving = true;
            }
        });
        $wire.on('saving-finished', (event) => {
            if (event.id == {{ $deliverable->id }}) {
                localSaving = false;
                lastSave = @this.lastSaved[{{ $deliverable->id }}];
                setTimeout(() => lastSave = '', 2000);
            }
        });
    "
>

    {{-- Título entregable --}}
    <div class="flex items-center gap-2">
        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
            Entregable #{{ $deliverable->id }}
        </h1>
    </div>

    {{-- Indicador de guardado --}}
    <div class="flex items-center gap-2 text-sm">
        <template x-if="localSaving">
            <span class="flex items-center gap-1 text-slate-500 dark:text-slate-400 animate-pulse">
                @svg('heroicon-o-arrow-path', 'w-4 h-4') Guardando...
            </span>
        </template>

        <template x-if="!localSaving && lastSave">
            <span class="flex items-center gap-1 text-green-600 dark:text-green-400 transition">
                @svg('heroicon-s-check-badge', 'w-4 h-4') Guardado @ <span x-text="lastSave"></span>
            </span>
        </template>
    </div>

    {{-- Botones de cambio de estado --}}
    <div class="flex gap-2 ml-auto">
        @if ($deliverable->status !== DeliverableStatusEnum::DRAFT->value)
            <x-ts-button
                wire:click="previousStatus"
                wire:loading.attr="disabled"
                size="sm"
                color="slate"
                icon="chevron-left"
            >
                Estado Anterior
            </x-ts-button>
        @endif

        <x-ts-button
            wire:click="changeStatus"
            wire:loading.delay.shortest.attr="disabled"
            size="sm"
            color="success"
            icon="chevron-right"
        >
            Siguiente Estado
        </x-ts-button>
    </div>
</div>
