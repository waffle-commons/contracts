<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use Waffle\Exception\SecurityException;

interface SecurityRuleInterface
{
    /**
     * @throws SecurityException
     */
    public function check(object $object): void;
}
