<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf;

/**
 * Issues, validates, and revokes CSRF tokens (Phase 6 / Roadmap Alpha 6 §6).
 *
 * Implementations MUST be **stateless from the application's perspective** —
 * any persistence happens in injected storage (Cache, signed cookies), never
 * in PHP sessions (FrankenPHP rule).
 *
 * `validate()` implementations MUST use `hash_equals()` to perform
 * constant-time comparison (defense against timing attacks).
 */
interface CsrfTokenManagerInterface
{
    /**
     * Issues a fresh token for the given logical id.
     *
     * @param string   $id          Logical bucket — see CsrfTokenInterface::getId().
     * @param int|null $ttlSeconds  Override the default TTL. `null` uses the
     *                              implementation's default.
     */
    public function issue(string $id, ?int $ttlSeconds = null): CsrfTokenInterface;

    /**
     * Returns true when `$candidate` matches a currently-valid token under `$id`,
     * comparing in constant time. Returns false for missing, expired, or
     * mismatched tokens — never throws on routine invalidation.
     */
    public function validate(string $id, string $candidate): bool;

    /**
     * Generates a new token for `$id`, invalidating the previous one. Useful
     * after sensitive state changes (login, password reset) to prevent
     * token-reuse attacks.
     */
    public function refresh(string $id): CsrfTokenInterface;

    /**
     * Best-effort token revocation.
     *
     * Cache-backed implementations clear the storage entry. Signed-cookie
     * implementations cannot truly revoke without rotating the signing key —
     * they document this limitation and silently no-op.
     */
    public function revoke(string $id): void;

    /**
     * Returns true when a non-expired token currently exists for `$id`.
     * Used by helper code that wants to avoid double-issuing tokens.
     */
    public function hasValid(string $id): bool;
}
