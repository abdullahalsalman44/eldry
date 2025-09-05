<?php

namespace App\Enums;

enum HealthEnum: string
{
    case GOOD = 'good';
    case NORMAL = 'normal';
    case NEED_DOCTOR = 'need_doctor';
}
