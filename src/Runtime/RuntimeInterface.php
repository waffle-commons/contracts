<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Runtime;

use Waffle\Commons\Contracts\Core\KernelInterface;

interface RuntimeInterface
{
    public function run(KernelInterface $kernel): void;
}
