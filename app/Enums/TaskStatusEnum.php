<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum TaskStatusEnum: string
{
    use ExtendedEnum;

    case PENDIENTE = 'Pendiente';
    case PAUSADA = 'Pausada';
    case EN_PROGRESO = 'En progreso';
    case TERMINADO = 'Terminado';
}
