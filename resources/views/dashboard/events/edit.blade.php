<x-app-layout>
    {{ Breadcrumbs::render('dashboard.events.edit', $event) }}

    @livewire('dashboard.events.form-component', [
        'event' => $event,
    ])

</x-app-layout>
