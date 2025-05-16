{{-- @use('App\Enums\TaskStatusEnum') --}}

<div class="p-6 space-y-6">
    <div class="w-full md:w-1/3">
        {{-- <x-ts-select.styled wire:model.live="project_id" label="Proyecto" :options="$projects_options" select="label:label|value:value" searchable /> --}}
    </div>

    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
        {{-- {{ $project_id == null ? 'Todas las Tareas' : 'Tareas del Proyecto: ' . $project_select->name }} --}}
    </h2>

    {{-- Tabla verdaderamente responsiva --}}
    <div class="w-full overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <table class="min-w-[1000px] table-auto bg-white dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100">
            <thead
                class="bg-slate-100 dark:bg-slate-800 text-xs uppercase font-medium text-slate-600 dark:text-slate-400 tracking-wider">
                <tr>
                    @foreach (['Proyecto', 'Tarea', 'Estatus', 'Entregable', 'Tiempo', 'Acciones', '', 'Prioridad'] as $header)
                        <th
                            class="px-4 py-3 text-left whitespace-nowrap border-b border-slate-300 dark:border-slate-600">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                @forelse ($tasks as $task)
                    <tr
                        class="{{ $i === 3 ? 'bg-red-100 dark:bg-red-900 hover:bg-red-50 dark:hover:bg-red-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }} transition">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $task->project->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $task->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{-- @php
                                $status = ['En progreso', 'Pendiente', 'Pausada'][$i - 1];
                                $color = match ($status) {
                                    'En progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'Pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'Pausada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                };
                            @endphp --}}
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 whitespace-nowrap">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ optional($task->deliverable)->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">

                            <div wire:key="task-{{ $task->id }}-{{ $task->status }}" x-data="{
                                elapsed: {{ $task->elapsed_time }} + ({{ $task->status == TaskStatusEnum::EN_PROGRESO->value
                                    ? 'Math.floor(Date.now() / 1000 - new Date(\'' .
                                        ($task->started_at ? $task->started_at->toIso8601String() : '') .
                                        '\').getTime() / 1000)'
                                    : '0' }}),
                                interval: null,
                                status: '{{ $task->status }}'
                            }"
                                x-init="if (status === '{{ TaskStatusEnum::EN_PROGRESO->value }}') {
                                    interval = setInterval(() => { elapsed++; }, 1000);
                                }"
                                x-effect="
                                        $watch('status', (newStatus) => {
                                            if (newStatus === '{{ TaskStatusEnum::EN_PROGRESO->value }}') {
                                                if (!interval) {
                                                    interval = setInterval(() => { elapsed++; }, 1000);
                                                }
                                            } else {
                                                clearInterval(interval);
                                                interval = null;
                                            }
                                        });
                                    ">
                                <span
                                    x-text="`${String(Math.floor(elapsed / 3600)).padStart(2, '0')}:${String(Math.floor((elapsed % 3600) / 60)).padStart(2, '0')}:${String(Math.floor(elapsed % 60)).padStart(2, '0')}`"></span>
                            </div>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($task->status === TaskStatusEnum::PAUSADA->value || $task->status === TaskStatusEnum::PENDIENTE->value)
                                    <x-ts-button color="success" size="sm"
                                        wire:click="startTask({{ $task->id }})">Iniciar</x-ts-button>
                                @elseif ($task->status === TaskStatusEnum::EN_PROGRESO->value)
                                    <x-ts-button color="warning" size="sm"
                                        wire:click="pauseTask({{ $task->id }})">Pausar</x-ts-button>
                                    <x-ts-button color="danger" size="sm"
                                        wire:click="confirmStop({{ $task->id }})">Finalizar</x-ts-button>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if ($task->deliverable)
                                <x-ui.tooltip :text="__('panel.general.mostrar')">
                                    <a href="{{ route('dashboard.projects.edit-deliverable', [$task->project->id, $task->deliverable->id]) }}"
                                        class="inline-flex items-center text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                        @svg('heroicon-o-eye', 'w-5 h-5')
                                    </a>
                                </x-ui.tooltip>
                            @else
                                @if ($task->ticket)
                                    <x-ui.tooltip :text="__('panel.general.mostrar')">
                                        <a href="{{ route('dashboard.tickets.show', $task->ticket->id) }}"
                                            class="inline-flex items-center text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                            @svg('heroicon-o-eye', 'w-5 h-5')
                                        </a>
                                    </x-ui.tooltip>
                                @endif
                            @endif
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400">P -
                                    {{ $task->priority }}</span>
                                <x-ui.tooltip text="Aumentar Prioridad">
                                    <button wire:click="aumentarPrioridad({{ $task->id }})" type="button"
                                        class="rounded-md bg-blue-100 hover:bg-blue-200 dark:bg-blue-800 dark:hover:bg-blue-700 p-1">
                                        <x-heroicon-o-chevron-up class="w-4 h-4 text-blue-600 dark:text-blue-300" />

                                    </button>
                                </x-ui.tooltip>
                                @if ($task->priority > 1)
                                    <x-ui.tooltip text="Disminuir Prioridad">
                                        <button wire:click="disminuirPrioridad({{ $task->id }})" type="button"
                                            class="rounded-md bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 p-1">
                                            <x-heroicon-o-chevron-down class="w-4 h-4 text-red-600 dark:text-red-300" />
                                        </button>
                                    </x-ui.tooltip>
                                @endif
                            </div>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-slate-500 dark:text-slate-400">No hay tareas
                            disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
