<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Resolves the address of the client behind a request ([NET-01]).
 *
 * Behind a reverse proxy or an ingress, `REMOTE_ADDR` is the proxy's address, and `X-Forwarded-For` holds
 * whatever the client wrote unless a trusted proxy appended to it. An implementation trusts the forwarded
 * chain only from an explicit allow-list of proxy addresses, and returns the right-most address that is not
 * a trusted proxy, so a client cannot choose its own key. Every IP-bound check — rate limiting first — goes
 * through it instead of reading `REMOTE_ADDR`.
 */
interface ClientIpResolverInterface
{
    /**
     * The client's IP address, or null when the request carries none (a request built outside a server).
     */
    public function resolve(ServerRequestInterface $request): ?string;
}
