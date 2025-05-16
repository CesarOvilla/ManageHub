<x-app-layout>
    {{ Breadcrumbs::render('dashboard.tickets.edit', $ticket) }}

    @livewire('dashboard.tickets.form-component', [
        'ticket' => $ticket,
    ])

</x-app-layout>
