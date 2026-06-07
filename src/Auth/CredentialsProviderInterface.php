<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

use Psr\Http\Message\RequestInterface;

/**
 * One outbound authentication scheme of the Universal Authentication Bridge
 * (RFC-021 §4.7): attaches credentials (signed identity assertion, Bearer
 * token, API key, Basic credentials) to an outgoing PSR-7 request before a
 * PSR-18 client sends it.
 *
 * Security rules (RFC-021 §3.2, outbound):
 *
 *  - **Host-gated** — `supports()` MUST restrict the provider to its intended
 *    target (typically a host allow-list) so credentials never leak to
 *    unrelated hosts.
 *  - **Never overwrite** — when the request already carries the target header
 *    the provider MUST return it unchanged.
 *
 * Implementations MUST be stateless; token caching, when needed, goes through
 * an injected PSR-16 cache (RFC-013), never through static state.
 */
interface CredentialsProviderInterface
{
    /**
     * True when this provider is responsible for the request's target
     * (host allow-list match, case-insensitive). Never inspects credentials.
     */
    public function supports(RequestInterface $request): bool;

    /**
     * Returns a request carrying this provider's credentials. MUST be a
     * no-op when the target header is already present, and MAY be a no-op
     * when no credential material is available (e.g. anonymous context).
     */
    public function apply(RequestInterface $request): RequestInterface;
}
