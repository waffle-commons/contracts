<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Runtime;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Core\KernelInterface;
use Waffle\Commons\Contracts\Http\ResponseEmitterInterface;

interface RuntimeInterface
{
    public function run(
        KernelInterface $kernel,
        ServerRequestInterface $request,
        ResponseEmitterInterface $emitter,
    ): void;
}
