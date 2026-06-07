<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

/**
 * Universal Authentication Bridge constants (RFC-021).
 *
 * These identify the standard transport locations, environment keys, and
 * security defaults used by the Waffle authentication implementations.
 * Concrete components may override most of them via configuration — the
 * cryptographic floors (`MIN_SECRET_BYTES`, `ASSERTION_TTL`) are mandates.
 */
final class Constant
{
    /**
     * HTTP header carrying the HMAC-signed identity assertion for
     * service-to-service identity propagation (RFC-021 §4.3).
     */
    public const string ASSERTION_HEADER = 'X-Wfl-Assert-User';

    /**
     * Environment-variable key conventionally used to inject the shared
     * authentication signing secret (sourced through `%env(...)%` config
     * placeholders — never runtime `getenv()`).
     */
    public const string SECRET_ENV_KEY = 'WAFFLE_AUTH_SECRET';

    /**
     * Strict assertion lifetime in seconds (anti-replay, RFC-021 §4.3).
     * `now − iat` beyond this window rejects with HTTP 403.
     */
    public const int ASSERTION_TTL = 5;

    /**
     * Minimum signing-secret length in bytes. 32 bytes matches the
     * HMAC-SHA256 security floor; shorter secrets are rejected at
     * construction time (fail-closed boot, RFC-021 §4.2).
     */
    public const int MIN_SECRET_BYTES = 32;

    /**
     * PSR-7 ServerRequest attribute key under which the verified
     * `UserIdentityInterface` is published by the authentication middleware
     * for downstream consumers (controllers, voters).
     */
    public const string REQUEST_ATTRIBUTE = '_auth_identity';

    /** Conventional header carrying an API key (RFC-021 §4.6). */
    public const string API_KEY_HEADER = 'X-Api-Key';

    /** Standard HTTP authorization header. */
    public const string AUTHORIZATION_HEADER = 'Authorization';

    /** Authorization-header scheme prefix for bearer tokens (RFC 6750). */
    public const string BEARER_PREFIX = 'Bearer ';

    /** Authorization-header scheme prefix for Basic credentials (RFC 7617). */
    public const string BASIC_PREFIX = 'Basic ';

    /** Assertion payload claim: unique user (subject) identifier. */
    public const string CLAIM_SUBJECT = 'usr';

    /** Assertion payload claim: user email address (valid format). */
    public const string CLAIM_EMAIL = 'eml';

    /** Assertion payload claim: ABAC authorization roles. */
    public const string CLAIM_ROLES = 'rol';

    /** Assertion payload claim: tenant/organisation id (multi-tenant routing). */
    public const string CLAIM_TENANT = 'ten';

    /** Assertion payload claim: generation timestamp (Unix seconds). */
    public const string CLAIM_ISSUED_AT = 'iat';

    /**
     * Assertion payload claim: expiry timestamp (Unix seconds). MUST satisfy
     * `exp ≤ iat + ASSERTION_TTL` — receivers reject wider windows.
     */
    public const string CLAIM_EXPIRES_AT = 'exp';

    /**
     * Assertion payload claim: keyed hash of the client's original IP —
     * `hex(HMAC-SHA256(clientIp, WAFFLE_AUTH_SECRET))`. IP-binding without
     * shipping the raw address (privacy-preserving anti-hijacking).
     */
    public const string CLAIM_IP_HASH = 'iph';

    /**
     * Cookie carrying the signed, short-lived OAuth2/OIDC transaction state
     * (`state`, `nonce`, PKCE verifier) between the authorization redirect
     * and the callback (RFC-021 §4.5). Stateless by design — never a session.
     */
    public const string OAUTH_TRANSACTION_COOKIE = 'WAFFLE_OAUTH_TX';

    /** Maximum OAuth transaction lifetime in seconds (10 minutes). */
    public const int OAUTH_TRANSACTION_TTL = 600;
}
