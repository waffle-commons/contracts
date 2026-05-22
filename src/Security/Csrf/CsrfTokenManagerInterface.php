<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf;

/**
 * Issues and validates CSRF tokens using the **signed double-submit cookie**
 * pattern with anonymous-session binding (Beta-1 / SEC-01, option C).
 *
 * Implementations MUST be stateless across requests (FrankenPHP rule). The
 * Beta-1 implementation is a self-validating signed token. Wire format
 * (binary, then base64url-encoded):
 *
 *     nonce (16 bytes) || expiresAt (8 bytes BE uint64) || hmac (32 bytes)
 *
 * `hmac = HMAC-SHA256(nonce || expiresAt || id || sessionId, secret)`.
 *
 * Both the logical `id` AND the per-browser anonymous session id are folded
 * into the HMAC payload:
 *   - the id prevents cross-form replay (a `form:login` token cannot validate
 *     against `form:account-deletion`);
 *   - the sessionId prevents cross-browser replay (a token minted for
 *     `WAFFLE_SID=A` cannot validate against `WAFFLE_SID=B`).
 *
 * `validate()` MUST use `hash_equals()` to defeat timing side channels.
 */
interface CsrfTokenManagerInterface
{
    /**
     * Issues a fresh signed token bound to `$id` and the anonymous session id.
     * No server-side storage is touched.
     *
     * @param string   $id          Logical bucket (e.g. "form:login").
     * @param string   $sessionId   The anonymous session identifier carried by
     *                              the `WAFFLE_SID` cookie. Folded into the
     *                              HMAC payload; tokens issued under one
     *                              session id NEVER validate under another.
     * @param int|null $ttlSeconds  Override the implementation's default TTL.
     *                              Use `0` to issue a non-expiring token.
     */
    public function issue(string $id, string $sessionId, ?int $ttlSeconds = null): CsrfTokenInterface;

    /**
     * Returns true when `$candidate` is a well-formed, non-expired, untampered
     * token issued for `$id` AND `$sessionId`. Constant-time comparison via
     * `hash_equals()`.
     *
     * Returns false (never throws) on any of: malformed encoding, wrong
     * length, expired payload, id mismatch, sessionId mismatch, or HMAC
     * mismatch.
     */
    public function validate(string $id, string $sessionId, string $candidate): bool;

    /**
     * Issues a new token for `$id`/`$sessionId`. With stateless signing there
     * is no previous token to invalidate server-side; old tokens remain valid
     * until their embedded `expiresAt` passes. Callers that need true
     * invalidation must rotate the signing secret.
     */
    public function refresh(string $id, string $sessionId): CsrfTokenInterface;

    /**
     * No-op for stateless signed-cookie implementations: individual tokens
     * cannot be revoked without rotating the signing secret. Documented for
     * API symmetry with cache-backed managers.
     */
    public function revoke(string $id): void;

    /**
     * Stateless implementations have no inventory and return `false`. Callers
     * that need a token MUST call `issue()` regardless of this result.
     */
    public function hasValid(string $id): bool;
}
