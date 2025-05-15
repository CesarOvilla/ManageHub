<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum Roles: string
{
    use ExtendedEnum;

    case ADMINISTRATOR = 'Administrator';
    case PROJECT_MANAGER = 'Project Manager';
    case PROGRAM_MANAGER = 'Program Manager';
    case SOFTWARE_DEVELOPER = 'Software Developer';
    case GRAPHIC_DESIGNER = 'Graphic Designer';
    case EXECUTIVE = 'Executive';
    case SALES = 'Sales';
    case MARKETING = 'Marketing';
    case PMO = 'Project Management Office';
    case HR = 'Human Resources';
    case CLIENT = 'Client';
}
