<x-app-layout>
    {{ Breadcrumbs::render('dashboard.projects.index') }}

    <x-page-header title="Proyectos">
        <x-ts-button href="{{ route('dashboard.projects.create') }}">
            Agregar
        </x-ts-button>
    </x-page-header>

    @livewire('dashboard.projects.projects-list')

    {{-- @livewire('dashboard.home.my-tasks') --}}

    {{-- @livewire('dashboard.users.users-table') --}}
</x-app-layout>
