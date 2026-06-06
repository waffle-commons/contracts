<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Auth\Exception\AuthenticationExceptionInterface;

/**
 * One inbound authentication scheme of the Universal Authentication Bridge
 * (RFC-021 §3.2): JWT bearer, HMAC assertion, API key, HTTP Basic, …
 *
 * The two-step contract enforces the fail-closed rule:
 *
 *  - `supports()` answers "does this request carry credentials of MY scheme?"
 *    and MUST NOT validate anything.
 *  - `authenticate()` validates the credentials and either returns the
 *    verified identity or THROWS. A supporting authenticator never lets an
 *    invalid credential degrade into an anonymous request, and the bridge
 *    never falls back to another scheme after a rejection.
 *
 * Implementations MUST be stateless services (FrankenPHP rule): all request
 * data comes from the PSR-7 message, all configuration from the constructor.
 */
interface AuthenticatorInterface
{
    /**
     * True when the request carries credentials this scheme understands
     * (e.g. its header is present). Presence check only — no validation.
     */
    public function supports(ServerRequestInterface $request): bool;

    /**
     * Validates the credentials carried by the request and returns the
     * verified identity.
     *
     * @throws AuthenticationExceptionInterface When the credentials are
     *                                          missing pieces, tampered,
     *                                          expired, or otherwise invalid.
     */
    public function authenticate(ServerRequestInterface $request): UserIdentityInterface;
}
