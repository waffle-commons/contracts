<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\EventDispatcher;

interface EventDispatcherInterface
{
    public function dispatch(object $event): object;
}