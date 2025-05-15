<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum EventTypeEnum: string
{
    use ExtendedEnum;

    case SCRUM = 'Scrum';
    case RETROSPECTIVA = 'Retrospectiva';
    case LLAMADA_CLIENTE = 'Llamada con el cliente';
    case LLAMADA_INTERNA = 'Llamada interna';
    case OTRO = 'Otro';

}
