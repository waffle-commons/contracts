<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf;

use DateTimeImmutable;

/**
 * Immutable representation of a single CSRF token (Phase 6 / Roadmap Alpha 6 §6).
 *
 * The framework treats tokens as opaque values: only the manager knows how to
 * validate them. Implementations of this interface are pure data holders.
 */
interface CsrfTokenInterface
{
    /**
     * Logical bucket identifier this token belongs to (e.g. "form:login",
     * "api:account-deletion"). Distinct ids allow rotating tokens for
     * different forms independently.
     */
    public function getId(): string;

    /**
     * The opaque token value transmitted to the client. Implementations
     * SHOULD use a cryptographically strong source (e.g. `random_bytes()`)
     * and base64url-encode the result.
     */
    public function getValue(): string;

    /** When the token was issued. */
    public function getIssuedAt(): DateTimeImmutable;

    /**
     * When the token expires, or `null` if the token never expires (rare —
     * only appropriate for long-lived double-submit cookie strategies).
     */
    public function getExpiresAt(): ?DateTimeImmutable;

    /**
     * Returns true when the token's expiry is in the past.
     *
     * @param DateTimeImmutable|null $now Override the clock — useful in tests.
     *                                    Defaults to "now" in the
     *                                    implementation's timezone.
     */
    public function isExpired(?DateTimeImmutable $now = null): bool;
}
