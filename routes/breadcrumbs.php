<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('Dashboard'), route('dashboard'));
});

// dashboard > users
Breadcrumbs::for('dashboard.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Usuarios', route('dashboard.users.index'));
});
// dashboard > users > create
Breadcrumbs::for('dashboard.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.users.index');
    $trail->push('Agregar', route('dashboard.users.create'));
});
// dashboard > users > {user} > edit
Breadcrumbs::for('dashboard.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('dashboard.users.index');
    $trail->push($user->name, route('dashboard.users.edit', $user));
});
//  ! breadcrumbs de proyectos
// dashboard > projects
Breadcrumbs::for('dashboard.projects.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Proyectos', route('dashboard.projects.index'));
});
// dashboard > projects > create
Breadcrumbs::for('dashboard.projects.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.projects.index');
    $trail->push('Nuevo proyecto', route('dashboard.projects.create'));
});
// dashboard > projects > {project} > show
Breadcrumbs::for('dashboard.projects.show', function (BreadcrumbTrail $trail, $project, $deliverable = null) {
    $trail->parent('dashboard.projects.index');
    $trail->push('Detalles - ' . $project->name, route('dashboard.projects.show', ['project' => $project, 'deliverable' => $deliverable]));
});
// dashboard > projects > {project} > edit
Breadcrumbs::for('dashboard.projects.edit', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('dashboard.projects.show', $project);
    $trail->push('Editar - ' . $project->name, route('dashboard.projects.edit', $project));
});



// ! breadcrumbs de tickets



// dashboard >  > tickets
Breadcrumbs::for('dashboard.tickets.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('Tickets'), route('dashboard.tickets.index'));
});

Breadcrumbs::for('dashboard.tickets.create', function ($trail) {
    $trail->parent('dashboard.tickets.index');
    $trail->push(__('Agregar ticket'), route('dashboard.tickets.create'));
});

Breadcrumbs::for('dashboard.tickets.edit', function ($trail, $ticket) {
    $trail->parent('dashboard.tickets.index');
    $trail->push('Ticket - #' . $ticket->id, route('dashboard.tickets.edit', $ticket));
});

Breadcrumbs::for('dashboard.tickets.show', function (BreadcrumbTrail $trail, $ticket) {
    $trail->parent('dashboard.tickets.index');
    $trail->push('Detalles - Ticket - #' . $ticket->id, route('dashboard.tickets.show', $ticket));
});

// ! breadcrumbs de eventos


// dashboard > events

Breadcrumbs::for('dashboard.events.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('Eventos'), route('dashboard.events.index'));
});

Breadcrumbs::for('dashboard.events.create', function ($trail) {
    $trail->parent('dashboard.events.index');
    $trail->push(__('Agregar evento'), route('dashboard.events.create'));
});

Breadcrumbs::for('dashboard.events.edit', function ($trail, $event) {
    $trail->parent('dashboard.events.index');
    $trail->push($event->name, route('dashboard.events.edit', $event));
});

// ! breadcrumbs de métricas

// dashboard > metricas

Breadcrumbs::for('dashboard.metrics.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('Metricas'), route('dashboard.metrics.index'));
});
