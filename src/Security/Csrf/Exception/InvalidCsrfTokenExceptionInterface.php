<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf\Exception;

/**
 * Thrown when the request supplies a CSRF token that fails constant-time
 * comparison against the active token for the route's id.
 *
 * Maps to HTTP 403 Forbidden when caught by the framework's error renderer.
 */
interface InvalidCsrfTokenExceptionInterface extends CsrfExceptionInterface
{
    /** The CSRF token bucket id that failed validation. */
    public function getTokenId(): string;
}
