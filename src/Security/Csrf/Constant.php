<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf;

/**
 * CSRF-subsystem constants (Phase 6 / Roadmap Alpha 6 §6, Beta-1 / SEC-01).
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

    /**
     * Minimum signing-secret length in bytes for the stateless signed
     * double-submit implementation. 32 bytes matches the HMAC-SHA256 block
     * security floor; shorter secrets are rejected at construction time.
     */
    public const int MIN_SECRET_BYTES = 32;

    /**
     * Environment-variable key conventionally used to inject the signing
     * secret. Concrete components may override via configuration.
     */
    public const string SECRET_ENV_KEY = 'WAFFLE_CSRF_SECRET';

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

    /**
     * Cookie carrying the anonymous-session identifier used to bind CSRF
     * tokens to a single browser (Beta-1 / SEC-01 option C).
     */
    public const string SESSION_COOKIE_NAME = 'WAFFLE_SID';

    /** Random bytes per anonymous session id. 32 bytes ⇒ 256-bit identifier. */
    public const int SESSION_ID_BYTES = 32;

    /**
     * PSR-7 ServerRequest attribute key under which the anonymous-session id
     * is published by AnonymousSessionMiddleware for downstream consumers
     * (CsrfMiddleware reads it from here).
     */
    public const string SESSION_REQUEST_ATTRIBUTE = '_anon_sid';

    /** Default lifetime of the anonymous-session cookie in seconds (30 days). */
    public const int SESSION_COOKIE_MAX_AGE = 2_592_000;
}
