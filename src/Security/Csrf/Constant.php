<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf;

/**
 * CSRF-subsystem constants (Phase 6 / Roadmap Alpha 6 §6).
 *
 * These identify the standard transport locations and defaults used by Waffle
 * CSRF implementations. Concrete components may override via configuration.
 */
final class Constant
{
    /** Default token bucket id used when `#[RequiresCsrfToken]` omits one. */
    public const string DEFAULT_TOKEN_ID = '_default';

    /** Default token TTL in seconds (1 hour). */
    public const int DEFAULT_TTL = 3_600;

    /** Conventional HTTP header carrying the CSRF token. */
    public const string HEADER_NAME = 'X-CSRF-Token';

    /**
     * Conventional cookie name for the double-submit cookie strategy
     * (matches the Angular / Axios default).
     */
    public const string COOKIE_NAME = 'XSRF-TOKEN';

    /** Conventional form field name for the synchronizer-token strategy. */
    public const string FORM_FIELD_NAME = '_csrf_token';

    /**
     * PSR-7 ServerRequest attribute key under which the active CsrfTokenInterface
     * instance is published by the middleware for downstream consumers.
     */
    public const string REQUEST_ATTRIBUTE = '_csrf_token';
}
