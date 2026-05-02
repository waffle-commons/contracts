<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Runtime;

use Waffle\Commons\Contracts\Core\KernelInterface;

interface RuntimeInterface
{
    public function loop(KernelInterface $kernel, int $maxRequests = 500): void;
}
