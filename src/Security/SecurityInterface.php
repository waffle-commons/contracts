<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use ReflectionException;
use Waffle\Exception\SecurityException;

interface SecurityInterface
{
    /**
     * @param object $object
     * @param string[] $expectations
     * @return void
     * @throws SecurityException|ReflectionException
     */
    public function analyze(object $object, array $expectations = []): void;
}
