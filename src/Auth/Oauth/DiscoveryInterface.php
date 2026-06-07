<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Oauth;

use Waffle\Commons\Contracts\Auth\Exception\OauthExceptionInterface;

/**
 * Resolves an issuer into its provider metadata via the OIDC discovery
 * document (`/.well-known/openid-configuration`, RFC-021 §4.5).
 *
 * Implementations fetch over PSR-18 and MUST cache the resolved document in
 * an injected PSR-16 cache (RFC-013) with a bounded TTL — never in static
 * state (FrankenPHP rule).
 */
interface DiscoveryInterface
{
    /**
     * Fetches (or returns the cached) metadata for the issuer.
     *
     * @param string $issuer The issuer base URL
     *                       (e.g. `https://accounts.google.com`).
     *
     * @throws OauthExceptionInterface When the document is unreachable,
     *                                 malformed, or its `issuer` does not
     *                                 match the requested one.
     */
    public function discover(string $issuer): ProviderMetadataInterface;
}
