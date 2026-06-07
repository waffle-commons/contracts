<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Token;

/**
 * The token material returned by an OAuth2 token endpoint (RFC-021 §4.5):
 * access token, optional OIDC ID token, optional refresh token, lifetime.
 *
 * Implementations MUST be immutable value objects and record their own
 * issuance instant so expiry can be evaluated without ambient state.
 */
interface TokenSetInterface
{
    /** The access token. Never empty. */
    public string $accessToken { get; }

    /** Token type as reported by the provider (normally `Bearer`). */
    public string $tokenType { get; }

    /** OIDC ID token (JWT), when the `openid` scope was granted. */
    public ?string $idToken { get; }

    /** Refresh token, when the grant produced one. */
    public ?string $refreshToken { get; }

    /** Lifetime in seconds as reported by the provider, or null. */
    public ?int $expiresIn { get; }

    /** Space-separated granted scopes, when the provider reports them. */
    public ?string $scope { get; }

    /** Instant (Unix seconds) at which this set was issued/received. */
    public int $issuedAt { get; }

    /**
     * True when the access token is past its lifetime at `$now` (defaults
     * to the current time). Sets without `expiresIn` never expire here —
     * callers decide their own policy.
     */
    public function isExpired(?int $now = null): bool;
}
