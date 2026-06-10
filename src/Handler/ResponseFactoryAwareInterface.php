<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Handler;

use Psr\Http\Message\ResponseFactoryInterface;

/**
 * Implemented by a controller (or other dispatch target) that needs the PSR-17
 * response factory injected before its action runs.
 *
 * The framework's controller dispatcher injects the factory via an explicit
 * `instanceof` check against this contract — never a loose `method_exists()`
 * heuristic (AXE-2 / ARCH-05, type-safe dispatching).
 */
interface ResponseFactoryAwareInterface
{
    /**
     * Inject the PSR-17 response factory. Called by the dispatcher before the
     * controller action executes.
     */
    public function setResponseFactory(ResponseFactoryInterface $responseFactory): void;
}
