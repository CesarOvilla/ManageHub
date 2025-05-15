<x-app-layout>
    {{ Breadcrumbs::render('dashboard.projects.edit', $project) }}

    @livewire('dashboard.projects.form-component', [
        'project' => $project,
    ])

</x-app-layout>
