<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A Kernel capable of running work AFTER the response has been emitted to the client.
 *
 * The Runtime invokes terminate() exactly once per request — after emit(), before
 * reset() — so heavy post-response tasks (async dispatch, buffer flushing) never
 * delay delivery of the response. Terminable support is OPTIONAL: the Runtime
 * guards the call with `instanceof`, so a kernel that does not implement this
 * interface simply skips the post-response phase.
 */
interface TerminableInterface
{
    /**
     * Runs post-response tasks for the given request/response pair.
     *
     * @param ServerRequestInterface $request  The request that was just handled.
     * @param ResponseInterface      $response The response that was just emitted.
     */
    public function terminate(ServerRequestInterface $request, ResponseInterface $response): void;
}
