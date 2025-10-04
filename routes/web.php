<?php

use App\Http\Controllers\Dashboard\EventsController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\MetricsController;
use App\Http\Controllers\Dashboard\ProjectsController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


    Route::prefix('dashboard/users')
        ->as('dashboard.users.')
        ->controller(UsersController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('{user}/edit', 'edit')->name('edit');
        });

    Route::prefix('dashboard/projects')
        ->as('dashboard.projects.')
        ->controller(ProjectsController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('{project}/edit', 'edit')->name('edit');
            Route::get('{project}/show/{deliverable?}', 'show')->name('show');
        });

    Route::prefix('dashboard/tickets')
        ->as('dashboard.tickets.')
        ->controller(TicketController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('{ticket}/edit', 'edit')->name('edit');
            Route::get('{ticket}/show', 'show')->name('show');
        });

    Route::prefix('dashboard/events')
        ->as('dashboard.events.')
        ->controller(EventsController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('{event}/edit', 'edit')->name('edit');
        });

    Route::prefix('dashboard/metrics')
        ->as('dashboard.metrics.')
        ->controller(MetricsController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
});
