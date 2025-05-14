<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Menu principal del sitio
     |--------------------------------------------------------------------------
     |
     | Aquí puedes configurar el menú principal del sitio.
     |
     | Las etiquetas para el menu seran pasadas por la función __() de Laravel
     | por lo que puedes usar etiquetas de idioma.
     |
     | active_route se usará para marcar como activo el elemento del menú, si
     | no se especifica se usará la ruta del elemento. Puedes usar rutas
     | wildcard, por ejemplo: 'dashboard.*' para marcar como activo todos los
     | elementos que comiencen con 'dashboard'.
     |
     | Los iconos usados son de la librería de iconos de HeroIcons
     | https://heroicons.com
     */
    'menu' => [
        [
            'label' => 'Inicio',
            'icon' => 'home',
            'route' => 'dashboard',
            'active_route' => 'dashboard',

        ],
        [
            'label' => 'Usuarios',
            'icon' => 'users',
            'route' => 'dashboard',
            'active_route' => 'dashboard.users.*',
        ],
        [
            'label' => 'Proyectos',
            'icon' => 'folder',
            'route' => 'dashboard',
            'active_route' => 'dashboard.projects.*',
        ],
        [
            'label' => 'Tickets',
            'icon' => 'ticket',
            'route' => 'dashboard',
            'active_route' => 'dashboard.tickets.*',

        ],
        [
            'label' => 'Roles y permisos',
            'icon' => 'shield-check',
            'route' => 'dashboard',
            'active_route' => 'dashboard.roles.*',
        ],
        [
            'label' => 'Eventos',
            'icon' => 'calendar',
            'route' => 'dashboard',
            'active_route' => 'dashboard.events.*',
        ],
        [
            'label' => 'Metricas',
            'icon' => 'pie-chart',
            'route' => 'dashboard',
            'active_route' => 'dashboard.metrics.*',
        ],
        [
            'label' => 'Control de tiempo',
            'icon' => 'clock',
            'route' => 'dashboard',
            'active_route' => 'dashboard.time-control.*',
            'items' => [
                [
                    'label' => 'Reporte de Horas',
                    'route' => 'dashboard',
                    'active_route' => 'dashboard.time-control.hourly-report.index',
                ],
                [
                    'label' => 'Tiempo de Tareas',
                    'route' => 'dashboard',
                    'active_route' => 'dashboard.time-control.tasks-time.index',
                ],
            ],
        ]

    ],
];
