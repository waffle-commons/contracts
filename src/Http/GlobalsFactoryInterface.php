<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Builds a PSR-7 server request from the ambient request context (PHP
 * superglobals / SAPI) at the start of each request.
 *
 * Distinct from PSR-17's {@see \Psr\Http\Message\ServerRequestFactoryInterface}
 * (which builds a request for an explicit method + URI): this factory captures
 * the *current* request from the environment, letting the runtime depend on the
 * abstraction instead of binding to the `http` component's concrete factory.
 */
interface GlobalsFactoryInterface
{
    public function createFromGlobals(): ServerRequestInterface;
}
