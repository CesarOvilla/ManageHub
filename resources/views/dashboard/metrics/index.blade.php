<x-app-layout>
    {{ Breadcrumbs::render('dashboard.metrics.index') }}

    <x-page-header title="Métricas" />


    <div class="space-y-4">

        <x-card>
            @livewire('dashboard.metrics.task-load-distribution-chart')
        </x-card>
        <x-card>
            <div class=" flex flex-row">
                <div class="w-1/3">
                    @livewire('dashboard.metrics.task-track-completion-chart')
                </div>
                <div class="w-2/3 border-l border-gray-300 pl-4">
                    @livewire('dashboard.metrics.tasks-per-project-chart')
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
