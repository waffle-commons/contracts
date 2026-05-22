<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing\Exception;

use RuntimeException;
use Throwable;

/**
 * Canonical "no route matched" exception, shared across components.
 *
 * Lives in `contracts` (not in `routing` or `pipeline`) so middleware and
 * error renderers can throw and catch the concrete type without violating the
 * component-agnosticism rule. `JsonErrorRenderer` checks
 * `instanceof RouteNotFoundExceptionInterface` for the 404 mapping — this class
 * satisfies that contract.
 */
final class RouteNotFoundException extends RuntimeException implements RouteNotFoundExceptionInterface
{
    public function __construct(string $message = 'Route not found.', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
