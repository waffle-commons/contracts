<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use ReflectionException;
use Waffle\Commons\Contracts\Security\Exception\SecurityExceptionInterface;

interface SecurityInterface
{
    /**
     * @param object $object
     * @param string[] $expectations
     * @return void
     * @throws SecurityExceptionInterface|ReflectionException
     */
    public function analyze(object $object, array $expectations = []): void;
}
