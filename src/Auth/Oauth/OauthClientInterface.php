<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Oauth;

use Waffle\Commons\Contracts\Auth\Exception\OauthExceptionInterface;
use Waffle\Commons\Contracts\Auth\Token\TokenSetInterface;

/**
 * The stateless OAuth2/OIDC relying-party engine (RFC-021 §4.5).
 *
 * A client instance is configured (constructor) with the provider metadata,
 * client id/secret, redirect URI, and scopes. The application wires the
 * login/callback routes; the engine never imposes URLs.
 *
 * Mandates:
 *  - Authorization Code ALWAYS uses PKCE with the S256 challenge method
 *    (`plain` is forbidden);
 *  - `state` is verified in constant time by the caller before
 *    `exchangeCode()` (the transaction codec carries it in a signed,
 *    short-TTL cookie — never a session);
 *  - ID tokens are validated through the JWT subsystem (§4.4), including
 *    the transaction `nonce`.
 */
interface OauthClientInterface
{
    /**
     * Builds the provider authorization URL for the Authorization Code +
     * PKCE grant.
     *
     * @param string $state         Opaque anti-CSRF transaction value.
     * @param string $nonce         OIDC replay binding for the ID token.
     * @param string $codeChallenge The S256 PKCE challenge
     *                              (`base64url(sha256(verifier))`).
     */
    public function createAuthorizationUrl(string $state, string $nonce, string $codeChallenge): string;

    /**
     * Exchanges an authorization code for tokens at the token endpoint.
     *
     * @param string $code         The authorization code from the callback.
     * @param string $codeVerifier The PKCE verifier minted with the
     *                             transaction.
     *
     * @throws OauthExceptionInterface On transport failure or a provider
     *                                 error response.
     */
    public function exchangeCode(string $code, string $codeVerifier): TokenSetInterface;

    /**
     * Acquires a service-to-service token via the Client Credentials grant.
     *
     * @param string|null $scope Space-separated scopes, or null for the
     *                           provider default.
     *
     * @throws OauthExceptionInterface On transport failure or a provider
     *                                 error response.
     */
    public function clientCredentials(?string $scope = null): TokenSetInterface;
}
