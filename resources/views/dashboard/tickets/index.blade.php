<x-app-layout>
    {{ Breadcrumbs::render('dashboard.tickets.index') }}

    <x-page-header title="Tickets">
        <x-ts-button href="{{ route('dashboard.tickets.create') }}">
            Agregar
        </x-ts-button>
    </x-page-header>

    @livewire('dashboard.tickets.tickets-table')

</x-app-layout>
