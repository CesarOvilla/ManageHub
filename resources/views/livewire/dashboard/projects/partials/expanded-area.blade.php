@use('App\Enums\DeliverableStatusEnum')
<div x-data="{ expanded: false }" class="w-full">
    <div class="flex justify-center mb-2">
        <button @click="expanded = !expanded"
            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm">
            <span x-text="expanded ? 'Ocultar campos' : 'Mostrar más campos'"></span>
            <i :class="expanded ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="ml-1"></i>
        </button>
    </div>

    <div x-show="expanded" class="flex flex-col w-ful rounded-lg">
        <x-ui.card-colapsable title="Criterios">
            {{-- @if ($deliverable->status == DeliverableStatusEnum::DRAFT->value)
                <div class="border border-gray-300 dark:border-gray-700 rounded-lg p-2 bg-white dark:bg-gray-800">
                    <livewire:quill-text-editor wire:key="criteria-{{ $deliverable->id }}"
                        id="criteria-{{ $deliverable->id }}"
                        wire:model.live="deliverables.{{ $deliverable->id }}.criteria" />
                </div>
            @else
                <div class="border border-gray-300 dark:border-gray-700 rounded-lg p-2 bg-white dark:bg-gray-800">
                    <div class="ql-bubble">
                        <div class="ql-editor ql-syntax">
                            {!! $deliverable->criteria !!}
                        </div>
                    </div>
                </div>
            @endIf --}}
            <div class="  rounded-lg p-2 bg-white dark:bg-gray-800">

                <livewire:ui.quill-text-editor
                    id="{{ $deliverable->status != DeliverableStatusEnum::DRAFT->value ? 'criteria-' . $deliverable->id : 'read-criteria-' . $deliverable->id }}"
                    wire:model.live="editDeliverable.criteria"
                    readOnly="{{ $deliverable->status != DeliverableStatusEnum::DRAFT->value }}" />

            </div>
        </x-ui.card-colapsable>


        @if ($deliverable->status != DeliverableStatusEnum::DRAFT->value)
            <x-ui.card-colapsable title="TechSpec">
                <div>
                    <div class="flex flex-wrap gap-4">
                        <x-ts-date label="Fecha de inicio" wire:model.live="editDeliverable.start_date"
                            :disabled="$deliverable->status !== DeliverableStatusEnum::RUNDOWN->value" />
                        <x-ts-date label="Fecha de finalización" wire:model.live="editDeliverable.end_date"
                            :disabled="$deliverable->status !== DeliverableStatusEnum::RUNDOWN->value" />
                        <x-ts-number label="Estimacion de tiempo" step="0.01" min="0"
                            wire:model.live="editDeliverable.estimated_hours" :disabled="$deliverable->status !== DeliverableStatusEnum::RUNDOWN->value" />
                    </div>

                    <!-- Row 3: Textarea que ocupa todo el ancho -->
                    <div class="mx-auto   rounded-md p-4 w-full">

                        <div class="flex flex-col">
                            <h2 class="text-xl font-semibold dark:text-gray-200">Especificaciones Técnicas</h2>
                            <livewire:ui.quill-text-editor
                                id="{{ $deliverable->status != DeliverableStatusEnum::DRAFT->value ? 'techspec-' . $deliverable->id : 'read-techspec-' . $deliverable->id }}"
                                wire:model.live="editDeliverable.techspec"
                                readOnly="{{ $deliverable->status != DeliverableStatusEnum::RUNDOWN->value }}" />


                        </div>
                    </div>
                </div>

            </x-ui.card-colapsable>

            <x-ui.card-colapsable title="Task">
                <div>

                    @php
                        $items = DeliverableStatusEnum::getStatusForTask($deliverable->status);
                    @endphp
                    @if (count($items) === 1)
                        <div class="flex items-center justify-end mb-4">
                            <x-ts-button text="Agregar Task" wire:click="addTask('{{ $items[0] }}')" />
                        </div>
                    @else
                        <div class="flex flex-row">
                            @foreach ($items as $elementName)
                                <div class="flex items-center justify-end mb-4 w-full">
                                    <x-ts-button text="Agregar Task" wire:click="addTask('{{ $elementName }}')" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        @if (count($items) === 1)
                            @foreach ($items as $elementName)
                                <span class="col-span-2 p-4 bg-gray-50 dark:bg-gray-800 rounded shadow">
                                    <strong class="dark:text-gray-200">{{ $elementName }}</strong>
                                </span>
                                @foreach ($tasks as $index => $task)
                                    @if ($task['stage'] === $elementName)
                                        <div class="col-span-1 p-4 bg-gray-50 dark:bg-gray-700 rounded shadow">
                                            <div class="flex flex-col w-full space-y-2">
                                                <!-- Primera columna: Nombre -->
                                                <div class="w-full">
                                                    <x-ts-input label="Nombre"
                                                        wire:model.live="tasks.{{ $index }}.name"
                                                        class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                                </div>
                                                <div class="flex flex-row space-x-2 w-full">
                                                    <div class="w-5/12">
                                                        <x-ts-select.styled label="Responsable"
                                                            wire:model.live="tasks.{{ $index }}.user_id"
                                                            :options="$usersProject" select="label:label|value:value"
                                                            :disabled="$task['elapsed_time'] != 0" searchable
                                                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                                    </div>
                                                    <div class="w-5/12 flex items-center pt-5">
                                                        <x-ts-checkbox label="Urgente"
                                                            wire:model.live="tasks.{{ $index }}.is_urgent"
                                                            class="dark:text-gray-200" />
                                                    </div>
                                                    <!-- Tercera columna: botón de eliminar -->
                                                    <div class="w-1/12 pt-5">
                                                        @if ($task['elapsed_time'] == 0)
                                                            <x-ts-button.circle icon="trash" color="red"
                                                                wire:click="deleteTask({{ $task['id'] }})"
                                                                wire:loading.attr="disabled"
                                                                class="dark:text-red-400 dark:hover:text-red-300" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($items as $elementName)
                                <div class="col-span-1 p-4 bg-gray-50 dark:bg-gray-800 rounded shadow">
                                    <strong class="dark:text-gray-200">{{ $elementName }}</strong>
                                    @foreach ($deliverable->tasks as $index => $task)
                                        @if ($task['stage'] === $elementName)
                                            <div class="mt-2 p-4 bg-white dark:bg-gray-700 rounded shadow">
                                                <div class="flex flex-col w-full space-y-2">
                                                    <div class="w-full">
                                                        <x-ts-input label="Nombre"
                                                            wire:model.live="tasks.{{ $index }}.name"
                                                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                                    </div>
                                                    <div class="flex flex-row space-x-2 w-full">
                                                        <div class="w-5/12">
                                                            <x-ts-select.styled label="Responsable"
                                                                wire:model.live="tasks.{{ $index }}.user_id"
                                                                :options="$usersProject" select="label:label|value:value"
                                                                :disabled="$task->elapsed_time != 0" searchable
                                                                class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                                        </div>
                                                        <div class="w-5/12 flex items-center pt-5">
                                                            <x-ts-checkbox label="Urgente"
                                                                wire:model.live="tasks.{{ $index }}.is_urgent"
                                                                class="dark:text-gray-200" />
                                                        </div>
                                                        <div class="w-1/12 pt-5">
                                                            @if ($task->elapsed_time == 0)
                                                                <x-ts-button.circle icon="trash" color="red"
                                                                    wire:click="deleteTask({{ $task->id }})"
                                                                    wire:loading.attr="disabled"
                                                                    class="dark:text-red-400 dark:hover:text-red-300" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>

            </x-ui.card-colapsable>

        @endif

    </div>
</div>
