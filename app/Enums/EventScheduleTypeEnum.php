<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum EventScheduleTypeEnum: string
{
    use ExtendedEnum;

    case DAILY = 'Diaria';
    case DAYS_OF_WEEK = 'Dias de la semana';
    case WEEKLY = 'Semanal';
    case TWO_WEEKS = 'Cada dos semanas';
    case MONTHLY = 'Mensual';

}
