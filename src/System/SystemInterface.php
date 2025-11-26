<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\System;

use Waffle\Commons\Contracts\Core\KernelInterface;
use Waffle\Router\Router;

interface SystemInterface
{
    public function boot(KernelInterface $kernel): self;

    public function registerRouter(Router $router): void;
}
