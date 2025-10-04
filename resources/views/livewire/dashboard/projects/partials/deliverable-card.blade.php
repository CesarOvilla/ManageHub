@use('App\Enums\DeliverableStatusEnum')
@php
    $shouldHighlight = isset($deliverable_search) && $deliverable_search->id === $deliverable->id;
@endphp

<div class="py-2" wire:key="deliverable-{{ $deliverable->id }}-{{ $deliverable->status }}" x-data="{ highlight: {{ $shouldHighlight ? 'true' : 'false' }}, }"
    x-init="if (highlight) setTimeout(() => highlight = false, 5000)" @click="highlight = false"
    :class="highlight ? 'shadow-[0_0_15px_4px_theme(colors.primary.500)] animate-pulse' : ''">
    <x-ts-card class="dark:bg-gray-800 dark:text-gray-200">
        <div class="flex flex-col items-start gap-3 w-full">
            <div class="justify-between w-full">
                @include('livewire.dashboard.projects.partials.status-controls', [
                    'deliverable' => $deliverable,
                ])
            </div>

            <!-- Información básica -->
            <div class="grid grid-cols-10 gap-4 p-4 w-full">
                <div class="col-span-2">
                    <x-ts-input label="Nombre" wire:model.live="deliverables.{{ $deliverable->id }}.name"
                        :disabled="$deliverable->status !== DeliverableStatusEnum::DRAFT->value" class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                </div>

                <!-- Campo de ticket -->
                <div class="col-span-2">
                    @php
                        $currentTicket = $deliverable->ticket;
                        $availableTickets = $projectTickets->filter(function ($ticket) use ($deliverable) {
                            return !$ticket->deliverable || $ticket->deliverable->id === $deliverable->id;
                        });

                        $formattedTickets = $availableTickets
                            ->map(function ($t) {
                                return ['value' => $t->id, 'label' => "#{$t->id} - {$t->title}"];
                            })
                            ->values()
                            ->toArray();
                    @endphp

                    @if ($deliverable->status == DeliverableStatusEnum::DRAFT->value)
                        <x-ts-select.styled label="Ticket"
                            wire:model.live="deliverables.{{ $deliverable->id }}.ticket_id" :options="$formattedTickets"
                            select="label:label|value:value" :disabled="$deliverable->status !== DeliverableStatusEnum::DRAFT->value"
                            placeholder="Seleccionar ticket"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    @else
                        <x-ts-input label="Ticket" :disabled="$deliverable->status !== DeliverableStatusEnum::DRAFT->value"
                            :value="optional($deliverable->ticket)->title ?? ''"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    @endIf
                </div>

                <div class="col-span-1">
                    @if ($deliverable->status == DeliverableStatusEnum::DRAFT->value)
                        <x-ts-select.styled label="Tipo" wire:model.live="deliverables.{{ $deliverable->id }}.type"
                            :options="$deliverables_type" select="label:label|value:value"
                            :disabled="$deliverable->status !== DeliverableStatusEnum::DRAFT->value"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    @else
                        <x-ts-input label="Tipo" :disabled="$deliverable->status !== DeliverableStatusEnum::DRAFT->value"
                            :value="$deliverable->type"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    @endIf
                </div>

                @if ($deliverable->status !== DeliverableStatusEnum::DRAFT->value)
                    <div class="col-span-2">
                        @php
                            $clipboardText =
                                "git checkout -b {$deliverable->project->convention}-{$deliverable->id}-" .
                                str_replace(' ', '-', strtolower($deliverable->name));
                        @endphp

                        <div x-data="{ text: '{{ $clipboardText }}', copied: false }">
                            <div class="flex flex-row items-center gap-2">
                                <div class="w-full">
                                    <x-ts-input label="Branch" :disabled="true" x-model="text"
                                        class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                </div>
                                <x-ts-button.circle class="mt-5 dark:text-gray-300 dark:hover:text-gray-100"
                                    icon="clipboard" flat
                                    @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)" />
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            @include('livewire.dashboard.projects.partials.expanded-area', [
                'deliverable' => $deliverable,
            ])
        </div>
    </x-ts-card>
</div>
