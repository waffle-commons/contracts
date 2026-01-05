<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Defines a strategy for rendering exceptions into HTTP responses.
 * Implementations can handle JSON (RFC 7807), HTML, or plain text depending on negotiation.
 */
interface ErrorRendererInterface
{
    /**
     * Renders a throwable into a PSR-7 Response.
     *
     * @param Throwable $e The caught exception.
     * @param ServerRequestInterface $request The request that caused the error (for content negotiation).
     */
    public function render(Throwable $e, ServerRequestInterface $request): ResponseInterface;
}
