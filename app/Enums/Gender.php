<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Gender: string
{
    use Values;

    case MALE = 'male';
    case FEMALE = 'female';
    case HERMAPHRODITE = 'hermaphrodite';
    case UNKNOWN = 'unknown';
    case NOT_APPLICABLE = 'n/a';
}
