<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum DeliverableStatusEnum: string
{
    use ExtendedEnum;

    case DRAFT = 'Draft';
    case RUNDOWN = 'Rundown';
    case DEVELOPMENT = 'Development';
    case VERIFICACION = 'Verificación';
    case VALIDACION = 'Validación';
    case ENTREGA = 'Entrega';
    case FINALIZADA = 'Finalizada';

    public static function getNextStatus(self $current): ?self
    {
        return match ($current) {
            self::DRAFT => self::RUNDOWN,
            self::RUNDOWN => self::DEVELOPMENT,
            self::DEVELOPMENT => self::VERIFICACION,
            self::VERIFICACION => self::VALIDACION,
            self::VALIDACION => self::ENTREGA,
            self::ENTREGA => self::FINALIZADA,
            default => null,
        };
    }

    public static function getPreviousStatus(self $current): ?self
    {
        return match ($current) {
            self::RUNDOWN => self::DRAFT,
            self::DEVELOPMENT => self::RUNDOWN,
            self::VERIFICACION => self::DEVELOPMENT,
            self::VALIDACION => self::VERIFICACION,
            self::ENTREGA => self::VALIDACION,
            self::FINALIZADA => self::ENTREGA,
            default => null,
        };
    }

    public static function getStatusForTask($taskStatus)
    {
        return match ($taskStatus) {
            Self::DRAFT->value => [],
            Self::RUNDOWN->value => [Self::RUNDOWN->value, Self::DEVELOPMENT->value],
            Self::DEVELOPMENT->value => [Self::DEVELOPMENT->value, Self::VERIFICACION->value],
            Self::VERIFICACION->value => [Self::VERIFICACION->value, Self::VALIDACION->value],
            Self::VALIDACION->value => [Self::VALIDACION->value, Self::ENTREGA->value],
            Self::ENTREGA->value => [Self::ENTREGA->value],
            default => [],
        };
    }
}
