<x-app-layout>
    {{ Breadcrumbs::render('dashboard.events.index') }}

    <x-page-header title="Eventos">
        <x-ts-button href="{{ route('dashboard.events.create') }}">
            Agregar
        </x-ts-button>
    </x-page-header>

    @livewire('dashboard.events.events-table')

</x-app-layout>
