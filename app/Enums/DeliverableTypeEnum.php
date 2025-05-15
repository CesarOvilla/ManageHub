<?php

namespace App\Enums;

use App\Enums\Concerns\ExtendedEnum;

enum DeliverableTypeEnum: string
{
    use ExtendedEnum;

    case FEATURE = 'Feature';
    case CONFIGURATION = 'Configuration';
    case UI_UX = 'UI/UX';
    case ISSUE = 'Issue';
    case BUG = 'Bug';
    case HOTFIX = 'HotFix';
}
