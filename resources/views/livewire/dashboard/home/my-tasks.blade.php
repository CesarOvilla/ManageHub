{{-- @use('App\Enums\TaskStatusEnum') --}}

<div class="p-6 space-y-6">
    <div class="w-full md:w-1/3">
        {{-- <x-ts-select.styled wire:model.live="project_id" label="Proyecto" :options="$projects_options" select="label:label|value:value" searchable /> --}}
    </div>

    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
        {{-- {{ $project_id == null ? 'Todas las Tareas' : 'Tareas del Proyecto: ' . $project_select->name }} --}}
    </h2>

    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <table
            class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100">
            <thead
                class="bg-slate-100 dark:bg-slate-800 text-xs uppercase font-medium text-slate-600 dark:text-slate-400 tracking-wider">
                <tr>
                    @foreach (['Proyecto', 'Tarea', 'Estatus', 'Entregable', 'Tiempo', 'Acciones', '', 'Prioridad'] as $header)
                        <th
                            class="px-4 py-3 text-left whitespace-nowrap border-b border-slate-300 dark:border-slate-600">
                            {{ $header }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                {{-- @forelse ($tasks as $task)
                    <tr
                        class="transition {{ $task->is_urgent ? 'bg-red-100 hover:bg-red-50 dark:bg-red-900 dark:hover:bg-red-800' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $task->project->name }}</td>
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $task->name }}</td>
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $task->status }}</td>
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ optional($task->deliverable)->name }}
                        </td>
                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
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
                        <td class="flex space-x-2 py-3 px-4">
                            @if ($task->status === TaskStatusEnum::PAUSADA->value || $task->status === TaskStatusEnum::PENDIENTE->value)
                                <button wire:click="startTask({{ $task->id }})"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                                    Iniciar
                                </button>
                            @elseif ($task->status === TaskStatusEnum::EN_PROGRESO->value)
                                <button wire:click="pauseTask({{ $task->id }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                                    Pausar
                                </button>
                                <button wire:click="confirmStop({{ $task->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                                    Finalizar
                                </button>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">Finalizado</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if ($task->deliverable)
                                <x-ui.tooltip :text="__('panel.general.mostrar')">
                                    <a href="{{ route('dashboard.projects.edit-deliverable', [$task->project->id, $task->deliverable->id]) }}"
                                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                        @svg('heroicon-o-eye', 'w-5 h-5')
                                    </a>
                                </x-ui.tooltip>
                            @else
                                @if ($task->ticket)
                                    <x-ui.tooltip :text="__('panel.general.mostrar')">
                                        <a href="{{ route('dashboard.tickets.show', $task->ticket->id) }}"
                                            class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                            @svg('heroicon-o-eye', 'w-5 h-5')
                                        </a>
                                    </x-ui.tooltip>
                                @endif
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="space-x-2">
                                <span class="text-gray-500 dark:text-gray-400">{{ $task->priority }}</span>
                                <x-ui.tooltip text="Aumentar Prioridad">
                                    <button wire:click="aumentarPrioridad({{ $task->id }})" type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 me-1 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        <x-heroicon-o-chevron-up class="w-5 h-5" />

                                    </button>
                                </x-ui.tooltip>
                                @if ($task->priority > 1)
                                    <x-ui.tooltip text="Disminuir Prioridad">
                                        <button wire:click="disminuirPrioridad({{ $task->id }})" type="button"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 me-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            <x-heroicon-o-chevron-down class="w-5 h-5" />
                                        </button>
                                    </x-ui.tooltip>
                                @endif
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 px-4 text-center text-gray-500 dark:text-gray-400">No hay tareas
                            disponibles.</td>
                    </tr>
                @endforelse --}}

                {{-- @forelse ($tasks as $task) --}}
                @foreach ([1, 2, 3] as $i)
                    <tr
                        class="{{ $i === 3 ? 'bg-red-100 dark:bg-red-900 hover:bg-red-50 dark:hover:bg-red-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }} transition">
                        <td class="px-4 py-3">Proyecto {{ ['Alpha', 'Beta', 'Gamma'][$i - 1] }}</td>
                        <td class="px-4 py-3">Tarea {{ $i }}</td>
                        <td class="px-4 py-3">
                            @php
                                $status = ['En progreso', 'Pendiente', 'Pausada'][$i - 1];
                                $color = match ($status) {
                                    'En progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'Pendiente'
                                        => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'Pausada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                };
                            @endphp
                            <span
                                class="px-2 py-1 rounded-md text-xs font-semibold {{ $color }}">{{ $status }}</span>
                        </td>
                        <td class="px-4 py-3">Entregable {{ $i }}</td>
                        <td class="px-4 py-3">0{{ $i }}:1{{ $i }}:3{{ $i }}</td>
                        <td class="px-4 py-3 space-x-2">
                            @if ($i === 1)
                                <x-ts-button color="warning" size="sm">Pausar</x-ts-button>
                                <x-ts-button color="danger" size="sm">Finalizar</x-ts-button>
                            @elseif ($i === 2 || $i === 3)
                                <x-ts-button color="success" size="sm">Iniciar</x-ts-button>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="inline-flex items-center text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                @svg('heroicon-o-eye', 'w-5 h-5')
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400">P{{ $i }}</span>
                                <button
                                    class="rounded-md bg-blue-100 hover:bg-blue-200 dark:bg-blue-800 dark:hover:bg-blue-700 p-1">
                                    @svg('heroicon-o-chevron-up', 'w-4 h-4 text-blue-600 dark:text-blue-300')
                                </button>
                                @if ($i > 1)
                                    <button
                                        class="rounded-md bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 p-1">
                                        @svg('heroicon-o-chevron-down', 'w-4 h-4 text-red-600 dark:text-red-300')
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                {{-- @empty --}}
                {{--     <tr><td colspan="8" class="text-center py-4 text-slate-500 dark:text-slate-400">No hay tareas disponibles.</td></tr> --}}
                {{-- @endforelse --}}
            </tbody>
        </table>
    </div>
</div>
