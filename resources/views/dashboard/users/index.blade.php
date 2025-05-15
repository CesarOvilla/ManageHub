<x-app-layout>
    {{ Breadcrumbs::render('dashboard.users.index') }}



    <x-page-header title="Usuarios">

        <x-ts-button href="{{ route('dashboard.users.create') }}">
            Agregar
        </x-ts-button>
    </x-page-header>

    @livewire('dashboard.users.users-table')
</x-app-layout>
