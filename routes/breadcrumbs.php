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
