<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    public function dispatch(object $event): object;
}