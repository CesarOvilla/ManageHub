<x-app-layout>
    {{ Breadcrumbs::render('dashboard.users.create') }}

    @livewire('dashboard.users.form-component', [
        'user' => $user,
    ])
</x-app-layout>
