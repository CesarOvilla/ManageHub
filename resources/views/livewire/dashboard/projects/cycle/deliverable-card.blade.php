@use('App\Enums\DeliverableStatusEnum')
@php
    $shouldHighlight = isset($deliverable_search) && $deliverable_search->id === $deliverable->id;
@endphp

<div
    class="relative overflow-visible p-4 transition-all duration-300 ease-in-out"
    x-data="{ highlight: {{ $shouldHighlight ? 'true' : 'false' }} }"
    x-init="if (highlight) setTimeout(() => highlight = false, 5000)"
    :class="highlight ? 'ring ring-pink-500 ring-offset-[3px]' : ''"
>
    <x-card class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-sm">

        {{-- Controles de estado --}}
        <div class="flex justify-between items-center pb-3">
            @include('livewire.dashboard.projects.partials.status-controls', ['deliverable' => $deliverable])
        </div>

        {{-- Grid compacto --}}
        <div class="grid grid-cols-12 gap-3 text-sm">
            <div class="col-span-12 sm:col-span-4 md:col-span-3">
                <x-ts-input label="Nombre" :value="$deliverable->name" disabled />
            </div>

            <div class="col-span-12 sm:col-span-4 md:col-span-3">
                <x-ts-input label="Ticket" :value="optional($deliverable->ticket)->title ?? ''" disabled />
            </div>

            <div class="col-span-6 sm:col-span-2 md:col-span-2">
                <x-ts-input label="Tipo" :value="$deliverable->type" disabled />
            </div>

            <div class="col-span-6 sm:col-span-2 md:col-span-2">
                <x-ts-input label="Responsable" :value="optional($deliverable->responsable)->name ?? ''" disabled />
            </div>

            {{-- Branch solo si no es DRAFT --}}
            @if ($deliverable->status !== DeliverableStatusEnum::DRAFT->value)
                <div class="col-span-12 md:col-span-6">
                    @php
                        $clipboardText = "git checkout -b {$deliverable->project->convention}-{$deliverable->id}-" .
                            str_replace(' ', '-', strtolower($deliverable->name));
                    @endphp

                    <div x-data="{ text: '{{ $clipboardText }}', copied: false }">
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Branch</label>
                        <div class="flex gap-2 items-center">
                            <input type="text" x-model="text" readonly
                                class="w-full rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 text-xs" />
                            <x-ts-button.circle icon="clipboard" size="xs"
                                @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)"
                                class="dark:text-slate-300 dark:hover:text-white"
                            />
                            <template x-if="copied">
                                <span class="text-xs text-green-500 font-medium ml-1">Copiado</span>
                            </template>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-span-12 md:col-span-2 flex items-end">
                <x-ts-button text="Editar" class="w-full"
                    href="{{ route('dashboard.projects.show', ['project' => $deliverable->project, 'deliverable' => $deliverable->id]) }}"
                    target="_blank"
                />
            </div>
        </div>
    </x-card>
</div>
