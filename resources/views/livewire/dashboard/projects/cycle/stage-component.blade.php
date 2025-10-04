@use('App\Enums\DeliverableStatusEnum')

<div class="space-y-6">

    {{-- Botón para agregar entregable --}}

    @if ($status === DeliverableStatusEnum::DRAFT->value)
        <div class="flex justify-end">
            <x-ts-button wire:click="addDeliverabeDraft()" icon="plus">
                Agregar Entregable
            </x-ts-button>
        </div>
    @endif


    {{-- Listado de entregables --}}
    @forelse ($deliverables as $index => $deliverable)
        <div  wire:key="deliverable-{{ $deliverable->id }}">
            @livewire(
                'dashboard.projects.cycle.deliverable-card',
                [
                    'deliverable' => $deliverable,
                    'deliverable_search' => $deliverable_search,
                ],
                key('deliverable-' . $deliverable->id)
            )
        </div>
    @empty
        <div class="text-center py-8">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                No hay entregables en este estado
            </p>
        </div>
    @endforelse

</div>
