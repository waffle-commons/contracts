<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Oauth;

/**
 * Immutable OAuth2/OIDC provider metadata (RFC-021 §4.5): the endpoints and
 * issuer a relying party needs, as published by the provider's discovery
 * document (`/.well-known/openid-configuration`) or by a shipped preset.
 */
interface ProviderMetadataInterface
{
    /** Issuer identifier; MUST equal the `iss` claim of issued ID tokens. */
    public string $issuer { get; }

    /** Authorization endpoint (user redirect target). */
    public string $authorizationEndpoint { get; }

    /** Token endpoint (code exchange / client-credentials grants). */
    public string $tokenEndpoint { get; }

    /** JWKS endpoint for token signature keys, when published. */
    public ?string $jwksUri { get; }

    /**
     * Userinfo endpoint, when published. Mandatory identity source for
     * OAuth2-only providers that issue no ID token (e.g. GitHub).
     */
    public ?string $userinfoEndpoint { get; }
}
