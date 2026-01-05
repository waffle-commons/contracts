<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Pipeline;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Defines a mutable collection of middlewares.
 * This interface allows the application (or plugins) to inject behaviors
 * into the HTTP pipeline before processing starts.
 */
interface MiddlewareStackInterface
{
    /**
     * Adds a middleware to the end of the stack (executed last before the controller).
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware): self;

    /**
     * Adds a middleware to the beginning of the stack (executed first).
     * Useful for critical middlewares (e.g., ErrorHandler, Logger).
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function prepend(MiddlewareInterface $middleware): self;

    /**
     * Returns the ordered list of middlewares.
     *
     * @return array<MiddlewareInterface>
     */
    public function getMiddlewares(): array;

    /**
     * Creates a PSR-15 RequestHandler capable of executing this stack.
     *
     * @param RequestHandlerInterface $fallbackHandler The handler to call when the stack is exhausted.
     * @return RequestHandlerInterface
     */
    public function createHandler(RequestHandlerInterface $fallbackHandler): RequestHandlerInterface;
}
