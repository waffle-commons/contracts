<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

/**
 * The portable, verified identity produced by any Universal Authentication
 * Bridge scheme (RFC-021 §4.1) — OAuth2/OIDC, JWT bearer, HMAC assertion,
 * API key, or HTTP Basic.
 *
 * Implementations MUST be immutable value objects: an identity is a fact
 * established at authentication time, never a mutable session. Mutable
 * per-request state belongs to {@see SecurityContextInterface}.
 */
interface UserIdentityInterface
{
    /** Stable unique subject identifier (the `sub` claim). Never empty. */
    public string $subject { get; }

    /** Verified email address, when the scheme provides one. */
    public ?string $email { get; }

    /**
     * Authorization roles granted to the subject, in declaration order.
     * Consumed by the authorization layer (RFC-002 voters) — never
     * interpreted by the bridge itself.
     *
     * @var list<string>
     */
    public array $roles { get; }

    /**
     * Scheme-specific extra claims (token claims, provider profile fields).
     * JSON-shaped data: values are scalars, nulls, or nested arrays thereof.
     *
     * @var array<string, mixed>
     */
    public array $claims { get; }
}
