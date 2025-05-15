<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum ProjectStatusEnum: string
{
    use ExtendedEnum;

    case LEVANTAMIENTO_DE_REQUERIMIENTOS = 'Levantamiento de requerimientos';
    case DESARROLLO = 'Desarrollo';
    case MANTENIMIENTO = 'Mantenimiento';
    case DETENIDO = 'Detenido';
    case CANCELADO = 'Cancelado';
}
