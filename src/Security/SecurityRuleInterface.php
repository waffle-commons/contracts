<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use Waffle\Commons\Contracts\Security\Exception\SecurityExceptionInterface;

interface SecurityRuleInterface
{
    /**
     * @throws SecurityExceptionInterface
     */
    public function check(object $object): void;
}
