<?php

namespace App\Enums\Concerns;

trait ExtendedEnum
{
    public static function asOptions(): array
    {
        return array_map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->description(),
            ];
        }, self::cases());
    }

    public function description(): string
    {
        return __($this->value);
    }

    public static function getValues(): array
    {
        return array_map(function ($case) {
            return $case->value;
        }, self::cases());
    }

    public static function getFilterTable(): array
    {
        return array_combine(
            array_map(fn($case) => $case->value, self::cases()),  // Claves (id)
            array_map(fn($case) => $case->description(), self::cases()) // Valores (name)
        );
    }
}
