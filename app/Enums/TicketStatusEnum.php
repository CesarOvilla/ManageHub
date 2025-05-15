<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum TicketStatusEnum: string
{
    use ExtendedEnum;

    case PENDIENTE = 'Pendiente';
    case ANALISIS = 'Analisis';
    case EN_PROGRESO = 'En progreso';
    case TERMINADO = 'Terminado';
}
