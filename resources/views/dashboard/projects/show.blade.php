<x-app-layout>
    {{ Breadcrumbs::render('dashboard.projects.show', $project) }}

    <x-page-header title="{{ $project->convention }} - {{ $project->name }}">

        <x-ts-button href="{{ route('dashboard.projects.edit', $project->id) }}">
            Editar Proyecto
        </x-ts-button>
    </x-page-header>

    <div class="py-2">
        <div class="max-w-full">

            <!-- Tarjeta principal con la información del proyecto -->
            @livewire('dashboard.projects.detail-project', ['project' => $project])

            <div class="space-x-2 pt-6">
                <x-ts-button href="{{ route('dashboard.projects.show', $project->id) }}">
                    Diagrama de Gantt
                </x-ts-button>
                <x-ts-button href="{{ route('dashboard.projects.show', $project->id) }}">
                    Metricas
                </x-ts-button>
                <x-ts-button href="{{ route('dashboard.projects.show', $project->id) }}">
                    Control de entregas
                </x-ts-button>
                <x-ts-button href="{{ route('dashboard.projects.show', $project->id) }}">
                    Tickets

                </x-ts-button>
                <x-ts-button href="{{ route('dashboard.projects.show', $project->id) }}">
                    Documentos
                </x-ts-button>
            </div>


            <x-card class="mt-6">
                @livewire('dashboard.projects.cycle.cycle-tabs', ['project' => $project, 'deliverable_search' => $deliverable])
            </x-card>

            <!-- Sección extra opcional (ej.: tareas, comentarios, etc.) -->

        </div>
    </div>

</x-app-layout>
