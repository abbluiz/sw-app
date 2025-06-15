<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Gender: string
{
    use Values;

    case MALE = 'Male';
    case FEMALE = 'Female';
    case UNKNOWN = 'unknown';
    case NOT_APPLICABLE = 'n/a';
}
