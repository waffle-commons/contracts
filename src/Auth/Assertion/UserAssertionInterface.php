<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Assertion;

/**
 * The signed identity assertion payload of the Gateway Assertion Protocol
 * (RFC-021 §4.3): the exact set of claims folded into the
 * `X-Wfl-Assert-User` header.
 *
 * Implementations MUST be immutable value objects. The claims map 1:1 to the
 * compact JSON wire keys declared in
 * {@see \Waffle\Commons\Contracts\Auth\Constant}:
 * `usr`, `eml`, `rol`, `ten`, `iat`, `exp`, `iph`.
 */
interface UserAssertionInterface
{
    /** Unique user (subject) identifier (`usr`). Never empty. */
    public string $subject { get; }

    /** User email address (`eml`), valid format when present. */
    public ?string $email { get; }

    /**
     * ABAC authorization roles (`rol`), in declaration order.
     *
     * @var list<string>
     */
    public array $roles { get; }

    /**
     * Tenant/organisation identifier (`ten`) for multi-tenant routing;
     * null on single-tenant deployments.
     */
    public ?string $tenant { get; }

    /** Generation timestamp in Unix seconds (`iat`). */
    public int $issuedAt { get; }

    /**
     * Expiry timestamp in Unix seconds (`exp`). Signers MUST set
     * `exp = iat + Constant::ASSERTION_TTL`; verifiers reject when `exp` is
     * past OR when `exp − iat` exceeds the TTL (window-widening attempts).
     */
    public int $expiresAt { get; }

    /**
     * Keyed hash of the client's original IP (`iph`):
     * `hex(HMAC-SHA256(clientIp, secret))`. The verifying peer recomputes
     * the hash over ITS observed client IP and compares with `hash_equals()`
     * — IP-binding without shipping the raw address.
     */
    public string $ipHash { get; }

    /** The canonical JSON wire payload of the seven claims. */
    public string $payload { get; }
}
