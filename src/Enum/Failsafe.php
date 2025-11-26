<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Enum;

use Waffle\Commons\Contracts\Constant\Constant;

enum Failsafe: string
{
    case ENABLED = Constant::ENABLED;
    case DISABLED = Constant::DISABLED;
}
