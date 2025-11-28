<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\System;

use Waffle\Commons\Contracts\Core\KernelInterface;

interface SystemInterface
{
    public function boot(KernelInterface $kernel): self;
}
