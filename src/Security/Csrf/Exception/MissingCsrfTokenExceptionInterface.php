<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf\Exception;

/**
 * Thrown when a route marked `#[RequiresCsrfToken]` is invoked with no token
 * supplied in any expected location (header, form field, double-submit cookie).
 *
 * Maps to HTTP 403 Forbidden. Distinguished from
 * `InvalidCsrfTokenExceptionInterface` so audit logs can differentiate
 * "user dropped the token" from "user attempted to forge one".
 */
interface MissingCsrfTokenExceptionInterface extends CsrfExceptionInterface
{
    /** The CSRF token bucket id that was required but absent. */
    public function getTokenId(): string;
}
